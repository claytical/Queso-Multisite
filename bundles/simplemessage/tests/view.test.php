<?php

use SimpleMessage\View;

class ViewTest extends PHPUnit_Framework_TestCase {

	/**
	 * Tear down the testing environment.
	 */
	public function tearDown()
	{
		View::$shared = array();
		unset(Event::$events['composing: test.basic']);
	}

	/**
	 * Test the View class constructor.
	 *
	 * @group laravel
	 */
	public function testEmptyGeneralMessageContainerSetOnViewWhenNoGeneralMessagesInSession()
	{
		$view = new View('home.index');

		$this->assertInstanceOf('\\SimpleMessage\\Messaging\\Typed\\Messages', $view->data['messages']);
	}

}