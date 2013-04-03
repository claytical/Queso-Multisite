<?php namespace SimpleMessage;

use Laravel\Session;
use SimpleMessage\Messaging\Typed\Messages as TypedMessages;

class View extends \Laravel\View {

	public function __construct($view, $data = array())
	{
		parent::__construct($view, $data);

		// If a session driver has been specified, we will bind an instance of the
		// message container to every view. If a container instance
		// exists in the session, we will use that instance.
		$key = 'messages';
		if ( ! isset($this->data[$key]))
		{
			if (Session::started() and Session::has($key))
			{
				$this->data[$key] = Session::get($key);
			}
			else
			{
				$this->data[$key] = new TypedMessages;
			}
		}
	}
}