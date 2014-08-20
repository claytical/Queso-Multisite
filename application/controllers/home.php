<?php

class Home_Controller extends Base_Controller {

	/*
	|--------------------------------------------------------------------------
	| The Default Controller
	|--------------------------------------------------------------------------
	|
	| Instead of using RESTful routes and anonymous functions, you might wish
	| to use controllers to organize your application API. You'll love them.
	|
	| This controller responds to URIs beginning with "home", and it also
	| serves as the default controller for the application, meaning it
	| handles requests to the root of the application.
	|
	| You can respond to GET requests to "/home/profile" like so:
	|
	|		public function action_profile()
	|		{
	|			return "This is your profile!";
	|		}
	|
	| Any extra segments are passed to the method as parameters:
	|
	|		public function action_profile($id)
	|		{
	|			return "This is the profile for user {$id}.";
	|		}
	|
	*/

	public function action_index()
	{
		if(Sentry::check() && Session::get('uid')) {
			$info = new StdClass;
//			$quote = json_decode(file_get_contents("http://api.theysaidso.com/qod.json?category=inspire"));
//			$info->quote = $quote->contents;
			$user = User::find(Session::get('uid'));
			$quests = $user->quests()->pivot();
			$notices = $user->notices()
							->where('hidden', '!=', 1);
			$info->notices = $notices->get();
            DB::table('notices')
                ->where('user_id', '=', Session::get('uid'))
                ->update(array('hidden' => TRUE));

            $info->quests = $quests;
			$info->courses = User::find(Session::get('uid'))->groups()->where('groups.active', '=', 1)->get();
			$info->previous_courses = User::find(Session::get('uid'))->groups()->where('groups.active', '=', 0)->get();

			$info->user = $user->first()->username;
			return View::make('home.dashboard')
					->with('info', $info);
		}
		else {
			return View::make('home.home');
		}
	}

}