<?php

use SimpleMessage\Messaging\Typed\Entry;

class TypedMessagesTest extends PHPUnit_Framework_TestCase {

  /**
   * The Typed\Messages instance.
   *
   * @var Messages
   */
  public $messages;

  /**
   * Setup the test environment.
   */
  public function setUp()
  {
    $this->messages = new SimpleMessage\Messaging\Typed\Messages;
  }

  /**
   * Tests the Messages:add_typed method
   *
   * @group laravel 
   */
  public function testAddTypedMethodCreatesEntry()
  {
    $this->messages->add_typed('test', 'info');

    $actual = $this->messages->messages['info'][0];
    $this->assertInstanceOf('\\SimpleMessage\\Messaging\\Typed\\Entry', $actual);
    $this->assertEquals('test', $actual->text);
    $this->assertEquals('info', $actual->type);
  }

  /**
   * Tests the Messages:add_typed method
   *
   * @group laravel 
   */
  public function testAddTypedMethodPutsMessagesInArray()
  {
    $this->messages->add_typed('test', 'info');
    $expected = array('info' => array( new Entry('test', 'info')));
    $this->assertEquals($expected, $this->messages->messages);
  }

  /**
   * Tests the Messages:add_typed method
   *
   * @group laravel 
   */
  public function testAddTypedMethodPutsDefaultMessagesUnderDefaultKey()
  {
    $this->messages->add_typed('test');
    $expected = array(':default:' => array( new Entry('test')));
    $this->assertEquals($expected, $this->messages->messages);
  }

  /**
   * Test the Messages::add_typed method
   *
   * @group laravel
   */
  public function testAddTypedMessagesDoesNotCreateDuplicateMessages()
  {
    $this->messages->add_typed('test', 'success');
    $this->messages->add_typed('test', 'success');
    $this->assertCount(1, $this->messages->messages);
  }

  /**
   * Tests Messages::add method
   * 
   * @group laravel
   */
  public function testAddMethodAddsEntrytoArray()
  {
    $this->messages->add('success', 'ok');
    $this->assertEquals(array('success' => array(new Entry('ok', 'success'))), $this->messages->messages);
  }

  /**
   * Tests Messages::all method
   * 
   * @group laravel
   */
  public function testAllMethodReturnsFlatArrayofEntries()
  {
    $this->messages->messages = array(
      'success' => array(new Entry('ok')),
      'error'   => array(new Entry('problem'), new Entry('hiccup'))  
    );

    $expected = array(new Entry('ok'), new Entry('problem'), new Entry('hiccup'));
    $this->assertEquals($expected, $this->messages->all());
  }

  /**
   * Tests Messages::has method
   * 
   * @group laravel
   */
  public function testHasMethodReturnsTrue()
  {
    $this->messages->messages = array('success' => array(new Entry('ok', 'success')));
    $this->assertTrue($this->messages->has('success'));
  }

  /**
   * Tests Messages::has method
   * 
   * @group laravel
   */
  public function testHasMethodReturnsFalse()
  {
    $this->assertFalse($this->messages->has('foo'));
  }

  /**
   * Tests Messages:first method
   * 
   * @group laravel
   */
  public function testFirstMethodRetrievesMesssagesByType()
  {
    $this->messages->messages = array('success' => array(new Entry('ok', 'success')));
    $this->assertEquals(new Entry('ok', 'success'), $this->messages->first('success'));
    $this->assertEquals(null, $this->messages->first('foo'));
  }

  /**
   * Tests Messages::get method
   *
   * @group laravel
   */
  public function testGetMethodRetrievesMessagesByType()
  {
    $this->messages->messages = array('success' => array(new Entry('ok', 'success')));
    $this->assertEquals(array(new Entry('ok', 'success')), $this->messages->get('success'));
    $this->assertEquals(array(), $this->messages->get('foo'));
  }

  /**
   * Test the Messages::first method.
   * Test the Messages::get method.
   * Test the Messages::all method.
   *
   * @group laravel
   */
  public function testMessagesRespectFormat()
  {
    $this->messages->add_typed('ok', 'success');
    $this->assertEquals(new Entry('<p class="success">ok</p>', 'success'), $this->messages->first(null, '<p class=":type">:message</p>'));
    $this->assertEquals(new Entry('<p class="success">ok</p>', 'success'), $this->messages->first('success', '<p class=":type">:message</p>'));
    $this->assertEquals(array(new Entry('<p class="success">ok</p>', 'success')), $this->messages->get('success', '<p class=":type">:message</p>'));
    $this->assertEquals(array(new Entry('<p class="success">ok</p>', 'success')), $this->messages->all('<p class=":type">:message</p>'));
  }

  /**
   * Test the Messages::get method.
   *
   * @group laravel
   */
  public function testMessageFormattingReturnsEntryCopy()
  {
    $this->messages->add_typed('ok', 'success');
    $this->assertEquals(array(new Entry('<p>ok</p>', 'success')), $this->messages->get('success', '<p>:message</p>'));
    $this->assertEquals(array('success' => array(new Entry('ok', 'success'))), $this->messages->messages);
  }
}