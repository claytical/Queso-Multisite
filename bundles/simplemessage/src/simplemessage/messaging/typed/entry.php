<?php namespace SimpleMessage\Messaging\Typed;

class Entry {
  
  /**
   * Message text
   * 
   * @var string
   */
  public $text;

  /**
   * Type of message
   * 
   * @var string
   */
  public $type;

  /**
   * Create a new message entry
   * 
   * @param string $text 
   * @param string $type 
   */
  public function __construct($text, $type = '')
  {
    $this->text = $text;
    $this->type = $type;
  }

  /**
   * Retrieves Entry object's string representation
   * 
   * @return string 
   */
  public function __toString()
  {
    return $this->text;
  }
}