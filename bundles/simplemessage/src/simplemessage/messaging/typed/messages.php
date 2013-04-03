<?php namespace SimpleMessage\Messaging\Typed;

class Messages extends \Laravel\Messages {

  /**
   * Default key for messages that don't have a type
   *
   * @var string
   */
  const default_type = ':default:';

  /**
   * Add a typed message to the collector
   *
   * <code>
   *    // Add a message with success type
   *    $messages->add('Your item has been added.', 'success');
   *
   *    // Add a message with no type
   *    $messages->add('Your item will be held for 30 days for review.');
   * </code>
   * 
   * @param string $message 
   * @param string $type
   */
  public function add_typed($message, $type = null)
  { 
    $entry = new Entry($message, $type);

    // we don't want nulls as array keys. so if we haven't been
    // given a type, we'll use a default type string instead.
    $key = is_null($type) ? self::default_type : $type;

    if ($this->unique($key, $message)) $this->messages[$key][] = $entry;
  }

  /**
   * Add a message. This method is kept for consistency with
   * the Laravel\Messages class, but it's recommended that you use
   * add_typed() instead.
   * 
   * @param string $key
   * @param string $message
   * @see  Laravel\Messaging\Messages::add
   */
  public function add($key, $message)
  {
    $this->add_typed($message, $key);
  }

  protected function unique($key, $message)
  {
    if ( ! isset($this->messages[$key])) return true;
    
    // we iterate over all messages of the given type (key)
    // and if we find one that has the same text (message)
    // as the one given, then we don't have a unique message.
    foreach ($this->messages[$key] as $entry)
    {
      if ($entry->text == $message) return false;
    }

    return true;
  }

  /**
   * Determine if messages exist for a given key.
   *
   * <code>
   *    // Is there a message for the e-mail attribute
   *    return $messages->has('email');
   *
   *    // Is there a message for the any attribute
   *    echo $messages->has();
   * </code>
   *
   * @param  string  $key
   * @return bool
   */
  public function has($key = null)
  {
    return $this->first($key) !== null;
  }

  /**
   * Get the first message from the container for a given key.
   *
   * <code>
   *    // Echo the first message out of all messages.
   *    echo $messages->first();
   *
   *    // Echo the first message for the e-mail attribute
   *    echo $messages->first('success');
   *
   *    // Format the first message for the e-mail attribute
   *    echo $messages->first('success', '<p>:message</p>');
   * </code>
   *
   * @param  string  $key
   * @param  string  $format
   * @return Entry
   */
  public function first($key = null, $format = null)
  {
    $message = parent::first($key, $format);

    return $message instanceof Entry ? $message : null;
  }

  /**
   * Get all of the messages for every type in the container.
   *
   * <code>
   *    // Get all of the messages in the collector
   *    $all = $messages->all();
   *
   *    // Format all of the messages in the collector
   *    $all = $messages->all('<p class=":type">:message</p>');
   * </code>
   *
   * @param  string  $format
   * @return array
   */
  public function all($format = null)
  {
    $format = ($format === null) ? $this->format : $format;

    return $this->flatten($format);
  }

  /**
   * Create a one-dimensional array of message entries
   * 
   * @param  string $format 
   * @return array
   */
  protected function flatten($format = null)
  {
    $flat = array();

    foreach ($this->messages as $entries)
    {
      if ($format != null) $entries = $this->transform($entries, $format);

      $flat = array_merge($flat, $entries);
    }

    return $flat;
  }

  /**
   * Format an array of messages.
   *
   * @param  array   $messages
   * @param  string  $format
   * @return array
   */
  protected function transform($messages, $format)
  {
    $messages = (array) $messages;
    $transformed = array();

    // we iterate over the entry array and make a formatted
    // copy of each entry, which we place in the transformed
    // array
    foreach ($messages as $entry)
    {
      $text = $format;
      $text = str_replace(':message', $entry->text, $text);
      $text = str_replace(':type', $entry->type, $text);

      $transformed[] = new Entry($text, $entry->type);
    }

    return $transformed;
  }
}