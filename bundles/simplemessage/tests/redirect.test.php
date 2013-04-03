<?php

use SimpleMessage\Redirect;

class RedirectTest extends PHPUnit_Framework_TestCase {

	/**
	 * Setup the test environment.
	 */
	public function setUp()
	{
		Config::set('session.driver', 'foo');
		Router::$routes = array();
		Router::$names = array();
		URL::$base = 'http://localhost/';
		Config::set('application.index', '');
	}

	/**
	 * Destroy the test environment.
	 */
	public function tearDown()
	{
		// @todo clear httpfoundation request data
		Config::set('session.driver', '');
		Router::$routes = array();
		Router::$names = array();
		URL::$base = '';
		Config::set('application.index', 'index.php');
		Session::$instance = null;
	}

	/**
	 * Tests the Redirect::with_message() method. 
	 */
	public function testWithMessageFlashesMessagesToTheSession()
	{
		$this->setSession();

		Redirect::to('')->with_message('Your thing was added');

		$actual = Session::$instance->session['data'][':new:']['messages'];
		$this->assertEquals('Your thing was added', $actual->first()->text);
	}

	/**
	 * Tests the Redirect::with_message() method.
	 */
	public function testWithMessageFlashesMessagesWithTypeToTheSession()
	{
		$this->setSession();

		Redirect::to('')->with_message('Your thing was added', 'success');

		$actual = Session::$instance->session['data'][':new:']['messages'];
		$this->assertEquals('Your thing was added', $actual->first()->text);
		$this->assertEquals('success', $actual->first()->type);
	}

	/**
	 * Tests the Redirect::with_lang_message() method.
	 */
	public function testWithLangMessageFlashesLanguageLineToTheSession()
	{
		$this->setSession();

		Redirect::to('')->with_lang_message('simplemessage::test.test_line');

		$actual = Session::$instance->session['data'][':new:']['messages'];
		$this->assertEquals('used for unit testing', $actual->first()->text);
	}

	/**
	 * Tests the Redirect::with_lang_message() method.
	 */
	public function testWithLangMessageFlashesMessagesWithTypeToSession()
	{
		$this->setSession();

		Redirect::to('')->with_lang_message('simplemessage::test.test_line', 'success');

		$actual = Session::$instance->session['data'][':new:']['messages'];
		$this->assertEquals('used for unit testing', $actual->first()->text);
		$this->assertEquals('success', $actual->first()->type);
	}

	/**
	 * Set the session payload instance.
	 */
	protected function setSession()
	{
		$driver = $this->getMock('Laravel\\Session\\Drivers\\Driver');

		Session::$instance = new Laravel\Session\Payload($driver);
	}

}