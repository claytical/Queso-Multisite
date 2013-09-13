<?php

/**
 * A Laravel package for working with Mailgun
 *
 * @package Mailgun
 * @author  Vincent Talbot <vincent.talbot@gmail.com>
 * @link    http://github.com/vtalbot/laravel-mailgun
 * @license MIT License
 */

class Mailgun
{
  public static function &message(\Closure $setter = null)
  {
    $mg = new Mailgun('messages', 'POST', array(), $setter);
    return $mg;
  }

  public static function &unsubscribe(\Closure $setter = null)
  {
    $mg = new Mailgun('unsubscribes', 'POST', array(), $setter);
    return $mg;
  }

  public static function &unsubscribes(\Closure $setter = null)
  {
    $mg = new Mailgun('unsubscribes', 'GET', array(), $setter);
    return $mg;
  }

  public static function &complaint(\Closure $setter = null)
  {
    $mg = new Mailgun('complaints', 'POST', array(), $setter);
    return $mg;
  }

  public static function &complaints(\Closure $setter = null)
  {
    $mg = new Mailgun('complaints', 'GET', array('limit' => 100, 'skip' => 0), $setter);
    return $mg;
  }

  public static function &bounce(\Closure $setter = null)
  {
    $mg = new Mailgun('bounces', 'POST', array(), $setter);
    return $mg;
  }

  public static function &bounces(\Closure $setter = null)
  {
    $mg = new Mailgun('bounces', 'GET', array('limit' => 100, 'skip' => 0), $setter);
    return $mg;
  }

  public static function &stats(\Closure $setter = null)
  {
    $mg = new Mailgun('stats', 'GET', array('limit' => 100, 'skip' => 0), $setter);
    return $mg;
  }

  public static function &log(\Closure $setter = null)
  {
    $mg = new Mailgun('log', 'GET', array('limit' => 100, 'skip' => 0), array(), $setter);
    return $mg;
  }

  public static function &route(\Closure $setter = null)
  {
    $mg = new Mailgun('routes', 'POST', array(), $setter);
    return $mg;
  }

  public static function &routes(\Closure $setter = null)
  {
    $mg = new Mailgun('routes', 'GET', array('limit' => 100, 'skip' => 0), $setter);
    return $mg;
  }

  public static function &mailbox(\Closure $setter = null)
  {
    $mg = new Mailgun('mailboxes', 'POST', array(), $setter);
    return $mg;
  }

  public static function &mailboxes(\Closure $setter = null)
  {
    $mg = new Mailgun('mailboxes', 'GET', array('limit' => 100, 'skip' => 0), $setter);
    return $mg;
  }

  public static function &compaigns(\Closure $setter = null)
  {
    $mg = new Mailgun('compaigns', 'GET', array('limit' => 100, 'skip' => 0), $setter);
    return $mg;
  }

  public static function &__callStatic($request, $arguments)
  {
    $method = 'GET';
    if (count($arguments) > 1)
    {
      $method = array_shift($arguments);
    }
    $setter = array_shift($arguments);
    $mg = new Mailgun($request, $method, array(), $setter);
    return $mg;
  }

  private $_ch = null;
  private $_data = array();
  private $_cmd;
  private $_method;
  private $_path;

  private function __construct($cmd, $method = 'GET', $default = array(), \Closure $setter = null)
  {
    $this->_cmd = $cmd;
    $this->_method = $method;
    $this->_data = $default;

    if (!is_null($setter))
    {
      $setter($this);
    }
  }

  public function deliver()
  {
    $this->_ch = curl_init();

    $url = Config::get('mailgun.base_url', Config::get('mailgun::mailgun.base_url'));

    if ($this->_cmd != 'routes' && $this->_cmd != 'lists') {
      /* The routes and lists commands do not use domain
       * in their URLs */
      $url .= Config::get('mailgun.domain', Config::get('mailgun::mailgun.domain')).'/';
    }

    $url .= $this->_cmd;

    if (isset($this->_path))
    {
      $url .= '/' . $this->_path;
    }

    $q = array();
    foreach ($this->_data as $key => $value)
    {
      $key = str_replace('_', '-', $key);
      if (is_array($value))
      {
        foreach ($value as $val)
        {
          $q[] = urlencode($key) . '=' . urlencode($val);
        }
      }
      else
      {
        $q[] = urlencode($key) . '=' . urlencode($value);
      }
    }

    $auth = 'api:'.Config::get('mailgun.api_key', Config::get('mailgun::mailgun.api_key'));

    if ($this->_method === 'GET' and count($q) > 0)
    {
      $url .= '?' . join('&', $q);
    }

    $options = array(
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_CUSTOMREQUEST => $this->_method,
      CURLOPT_URL => $url,
      CURLOPT_USERPWD => $auth,
      CURLOPT_SSL_VERIFYHOST => false,
      CURLOPT_SSL_VERIFYPEER => false,
    );

    if ($this->_method === 'POST' || $this->_method === 'PUT')
    {
      $options[CURLOPT_POST] = true;
      $options[CURLOPT_POSTFIELDS] = join('&', $q);
    }

    curl_setopt_array($this->_ch, $options);


    $response = curl_exec($this->_ch);
    curl_close($this->_ch);

    return $response;
  }

  public function __get($key)
  {
    if (isset($this->_data[$key]))
    {
      return $this->_data[$key];
    }

    return false;
  }

  public function __set($key, $value)
  {
    if (!isset($this->_data[$key]))
    {
      $this->_data[$key] = $value;
    }
    else
    {
      if (!is_array($this->_data[$key]))
      {
        $this->_data[$key] = array($this->_data[$key]);
      }

      $this->_data[$key][] = $value;
    }
  }

  public function param($key, $value)
  {
    $this->_data[$key] = $value;
    return $this;
  }

  public function __call($method, $args)
  {
    if (count($args) === 1)
    {
      $this->_data[$method] = $args[0];
    }
    else if (count($args) > 1)
    {
      $this->_data[$method] = $args;
    }

    return $this;
  }

  public function path($value)
  {
    $this->_path = $value;
    return $this;
  }

  public function delete()
  {
    $this->_method = 'DELETE';
    return $this;
  }

  public function put()
  {
    $this->_method = 'PUT';
    return $this;
  }

  public function post()
  {
    $this->_method = 'POST';
    return $this;
  }

  public function get()
  {
    $this->_method = 'GET';
    return $this;
  }
}
