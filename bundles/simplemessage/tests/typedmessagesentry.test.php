<?php use SimpleMessage\Messaging\Typed\Entry;

class EntryTest extends PHPUnit_Framework_TestCase {
  
  /**
   * Tests Entry::__toString method
   *
   * @group laravel 
   */
  public function testToStringReturnsEntryText()
  {
    $this->assertEquals('test', new Entry('test'));
  }
}