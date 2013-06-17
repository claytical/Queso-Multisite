<?php

// User controller is responsible for showing logged in user's profile, posting a critt and following/unfollowing other users

class User_Controller extends Base_Controller {

	// Since we will use get and post, we need to make controller to be RESTful.
	public $restful = true;

	// Attach an Auth filter to every route in this controller to make sure the user is logged in
	public function __construct(){
		//$this->filter('before', 'auth');
	}
	public function get_register_instructor() {
		return View::make('user.register_instructor');
	}

	public function post_register_instructor() {
		$course_data = array('name' => Input::get('course'));
		$course_id = Sentry::group()->create($course_data);
	    $course = Group::find($course_id);
	    $codeNeedsRefresh = TRUE;
	    while ($codeNeedsRefresh) {
		    $code = Course::generate_code();	    	
			if(Group::where('code', '=', $code)->count() == 0) {
				$course->code = $code;
				$codeNeedsRefresh = FALSE;
			}
	    }

	    $course->save();

		if ($course_id) {
			try {
			// create the user - no activation required
				$vars = array(
					'email'    => Input::get('email'),
					'password' => Input::get('password'),
					'username' => Input::get('firstname') . " " . Input::get('lastname'),
					'metadata' => array(
						'first_name' => Input::get('firstname'),
						'last_name'  => Input::get('lastname'),
					)
				);

			$user_id = Sentry::user()->create($vars);

			if ($user_id) {

				// the user was created - send email notifying user account was created
			    // Find the group using the group id


			    // Assign the group to the user
				$user = Sentry::user($user_id);
			    if ($user->add_to_group($course_id)) {
			        // Group assigned successfully
						Session::put('uid', $user_id);
						Session::put('current_course', $course_id);
						Session::put('course_name', Input::get('course'));
						Sentry::login(Input::get('email'), Input::get('password'), true);
			    		DB::table('users_groups')
			    			->where('user_id', '=', Session::get('uid'))
			    			->where('group_id', '=', $course_id)
			    			->update(array('instructor' => 1));

						return Redirect::to('admin/skills');
		
			    }
			    else {
			        // Group was not assigned
			    }
			}
			
			else {
				// something went wrong - shouldn't really happen
			}
		}

		catch (Sentry\SentryException $e) {
			$errors = $e->getMessage(); // catch errors such as user exists or bad fields
		}
	}

}

	public function get_register() {
		return View::make('user.register');
	}

	public function post_register() {
		$course = Course::lookup(Input::get('regcode'));
		if ($course) {
			try {
			// create the user - no activation required
			$vars = array(
				'email'    => Input::get('email'),
				'password' => Input::get('password'),
				'username' => Input::get('firstname') . " " . Input::get('lastname'),
				'metadata' => array(
					'first_name' => Input::get('firstname'),
					'last_name'  => Input::get('lastname'),
				)
			);

			$user_id = Sentry::user()->create($vars);
			if ($user_id) {

				// the user was created - send email notifying user account was created
			    // Find the group using the group id


			    // Assign the group to the user
				$user = Sentry::user($user_id);
			    if ($user->add_to_group($course->id)) {
			        // Group assigned successfully
						Session::put('uid', $user_id);
						Session::put('current_course', $course->id);
						Session::put('course_name', $course->name);
						Sentry::login(Input::get('email'), Input::get('password'), true);

						return Redirect::to('/');
		
			    }
			    else {
			        // Group was not assigned
			    }
			}
			
			else {
				// something went wrong - shouldn't really happen
			}
		}

		catch (Sentry\SentryException $e) {
			return View::make('user.registered')
					->with('errors', $errors);
		}



		}
	
	}

	public function get_add_course() {
		return View::make('user.addcourse');

	}

	public function post_add_course() {
		$course = Course::lookup(Input::get('regcode'));
		if ($course) {	    
			$user = Sentry::user(Session::get('uid'));
			if ($user->add_to_group($course->id)) {

	        // Group assigned successfully
				Session::put('current_course', $course->id);
				Session::put('course_name', $course->name);

				return Redirect::to('/');
				}
			}
			else {
				return View::make('user.badcode');
			}
	}
	public function post_remove_quest() {
		$in_class = Input::get('removeQuest');
		$submissions = Input::get('removeSubmission');
		//$uploads = Input::get('removeUpload');
		$quest_id = Input::get('quest_id');
		if ($in_class) {
			foreach($in_class as $user_id) {
				DB::table('skill_user')
					->where('user_id', '=', $user_id)
					->where('quest_id', '=', $quest_id)
					->delete();
				DB::table('quest_user')
					->where('user_id', '=', $user_id)
					->where('quest_id', '=', $quest_id)
					->delete();
			}
		}

		if ($submissions) {
			foreach($submissions as $user_id) {
				DB::table('skill_user')
					->where('user_id', '=', $user_id)
					->where('quest_id', '=', $quest_id)
					->delete();
				DB::table('quest_user')
					->where('user_id', '=', $user_id)
					->where('quest_id', '=', $quest_id)
					->delete();
				DB::table('submissions')
					->where('user_id', '=', $user_id)
					->where('quest_id', '=', $quest_id)
					->delete();					
			}

		}
		return Redirect::to('/admin/quests/completed/'.$quest_id);
	}

	public function get_login() {
		return View::make('user.login');
	
	}
	
	public function post_login() {
		try {
			// log the user in
			$valid_login = Sentry::login(Input::get('email'), Input::get('password'), true);
		if ($valid_login) {
			// the user is now logged in - do your own logic
			$logged_in_user = User::where('email', '=', Input::get('email'))->first();
			Session::put('uid', $logged_in_user->id);
			if (!empty($logged_in_user->groups()->first()->id)) {
				Session::put('current_course', $logged_in_user->groups()->first()->id);
				Session::put('course_name', $logged_in_user->groups()->first()->name);
			
			}
			else {
				return Redirect::to('/no-course');

			}
			return Redirect::to('/posts');

  			}
		else {
			// could not log the user in - do your bad login logic
			return Redirect::to('login')
					->with_message("Invalid login", 'error');

		
			}
		}
		catch (Sentry\SentryException $e) {
			// issue logging in via Sentry - lets catch the sentry error thrown
			// store/set and display caught exceptions such as a suspended user with limit attempts feature.
			$errors = $e->getMessage();
		
		}
	
	}

	public function get_logout() {
		Sentry::logout();
		Session::flush();
		return View::make('user.login');
		
	}	
	
	
	
	public function get_list() {
		$users = Group::find(Session::get('current_course'))
						->users()
						->where('activated', '=', 1)
						->get();
		foreach ($users as $user) {
			$usersWithLevels[] = array('personal' => $user,
									   'current_level' => Student::current_level($user->id, Session::get('current_course')));
		}	
		return View::make('user.list')
		->with('users',$usersWithLevels);
	}

	public function get_remove($id) {
		Sentry::user($id)->delete();
		Answer::where('user_id', '=', $id)->delete();
		Notice::where('user_id', '=', $id)->delete();
		Post::where('user_id', '=', $id)->delete();
		Question::where('user_id', '=', $id)->delete();
		Submission::where('user_id', '=', $id)->delete();
		DB::table('quest_user')
			->where('user_id', '=', $id)
			->delete();
		DB::table('skill_user')
			->where('user_id', '=', $id)
			->delete();
		DB::table('users_groups')
			->where('user_id', '=', $id)
			->delete();
		
		return Redirect::to('/admin/users');


	}
	public function get_deactivate($id) {
		$affected = DB::table('users_groups')
					->where('user_id', '=', $id)
					->where('group_id', '=', Session::get('current_course'))
					->update(array('active' => '0'));
		return Redirect::to('admin/students');
	}

	public function get_profile($id = NULL) {
		$data = new stdClass();
		if ($id == NULL) {
			$id = Session::get('uid');
		}
		$data->user = User::find($id);
		
		$completed_quests = User::find($id)
					  ->quests()
					  ->where('group_id', '=', Session::get('current_course'));

		//gets the user skills for the course with timestamps
		$user_skills_over_time = DB::table('skill_user')
								->where('user_id', '=', $id)
								->where('group_id', '=', Session::get('current_course'))
								->order_by('created_at')
								->get();
		//creates separate array of just dates, 
		foreach($user_skills_over_time as $skill) {
			$created_date = strtotime($skill->created_at);
			$dates[] = date("Y-m-d", $created_date);
		}
		//create dates for chart
		if(!empty($dates)) {
			$data->dates = array_unique($dates);
		}
		$skills_for_course = Group::find(Session::get('current_course'))->skills()->get();
		//find each skill amount for each date
		foreach ($skills_for_course as $skill) {
			if (!empty($dates)) {
				foreach ($data->dates as $date) {
					$data->progress_by_skill[$skill->name][$date] = array(
					 								'amount' =>	DB::table('skill_user')
														->where('user_id', '=', $id)
														->where('skill_id', '=', $skill->id)
														->where('skill_user.created_at', '<', $date . ' 23:59:59')
														->sum('amount')
														);
					}
			}
		}

		//quest categories for completed quests
		$data->categories = array_unique($completed_quests->lists('category'));

		//course skills
		$skills = Group::find(Session::get('current_course'))
							->skills()
							->order_by('name', 'asc')
							->get();


		//student total skills
		foreach($skills as $skill) {
			$data->skills[] = array('label' => $skill->name,
									'amount' => 
										DB::table('skill_user')
										->where('user_id', '=', $id)
										->where('group_id', '=', Session::get('current_course'))
										->where('skill_id', '=', $skill->id)
										->sum('amount'));
		
		}

		//student quests with skills acquired
		foreach ($completed_quests->get() as $quest) {
			$quest_skills = DB::table('quest_skill')
				->join('skills', 'quest_skill.skill_id', '=', 'skills.id')
				->where('quest_id', '=', $quest->quest_id)
				->lists('skill_id','amount');
			$skill_list = array_unique($quest_skills);
			foreach ($skill_list as $skill) {
				$data->questMaxPoints[$skill] = DB::table('quest_skill')
							->where('quest_id', '=', $quest->quest_id)
							->where('skill_id', '=', $skill)
							->max('amount');
			}

			switch ($quest->type) {
				case 1:
					$submission = FALSE;
				break;

				case 2:
					$submission = Submission::where('quest_id', '=', $quest->quest_id)
											->where('user_id', '=', $id)
											->order_by("created_at", "DESC")
											->first();
				break;
			}
			$data->quests[] = array('name' => $quest->name,
								  'quest_id' => $quest->quest_id,
								  'completed' => $quest->created_at,
								  'category' => $quest->category,
								  'submission' => $submission,
								  'type' => $quest->type,
								  'skills' => DB::table('skill_user')
										->join('skills', 'skill_user.skill_id', '=', 'skills.id')
										->where('user_id', '=', $id)
										->where('skills.group_id', '=', Session::get('current_course'))
										->where('quest_id', '=', $quest->quest_id)
										->get());
		}
		
		$lowest_skill_amount = 99999999;
		foreach($skills as $skill) {
			$amount = DB::table('skill_user')
						->where('user_id', '=', $id)
						->where('skill_id', '=', $skill->id)
						->sum('amount');
			
			if ($amount == NULL) {
				$amount = 0;
			}		
			if ($amount < $lowest_skill_amount) {
				$lowest_skill_amount = $amount;	
			}
			
		}

		$data->current_level = Student::current_level($id, Session::get('current_course'));				
		return View::make('user.profile')
			->with('data', $data);
	
	}
	
	public function get_edit($id) {
		return View::make('user.details')
		->with('users', User::find($id));
	
	}

	public function get_promote($user_id) {
		DB::table('users_groups')
			->where('user_id', '=', $user_id)
			->where('group_id', '=', Session::get('current_course'))
			->update(array('instructor' => 1));

		return Redirect::to('admin/students');
	}

	public function get_demote($user_id) {
		DB::table('users_groups')
			->where('user_id', '=', $user_id)
			->where('group_id', '=', Session::get('current_course'))
			->update(array('instructor' => 0));
		return Redirect::to('admin/students');
	}

	public function get_change_password() {
		return View::make('user.changepw');	
	}
	
	public function get_change_any_password($id) {
		return View::make('user.changepw_admin')
					->with('user', User::find($id));
	}
	
	public function post_change_any_password() {
			$user = Sentry::user(Input::get('user'));
			
			if ($user->change_password(Input::get('password'), Input::get('password'))) {
				// password has been updated

			}
			else {
				// something went wrong
			}
	
	}
	public function post_change_password() {
		try {
			// update the user
			
			$user = Sentry::user(Session::get('uid'));
			
			if ($user->change_password(Input::get('password'), Input::get('password_old'))) {
				// password has been updated

			}
			else {
				// something went wrong
			}
		}

		catch (Sentry\SentryException $e) {
			$errors = $e->getMessage(); // catch errors such as incorrect old password
		}
				return View::make('user.reset');	
	}
	

	
		
	public function get_index()
	{
		return View::make('user.index')
			->with('users', User::all());	

	}

	public function get_preferences() {
		$user = User::find(Session::get('uid'));
		if (!$user->photo) {
			$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $user->email ) ) );
			$user->photo_url = $grav_url;
		}
		else {
			$user->photo_url = $user->photo;
		}
		return View::make('user.preferences')
			->with('user', $user);

	}

	public function post_preferences() {
		$user = User::find(Session::get('uid'));
		$notifications = Input::has('email_notifications');
		$email = Input::get('email');
		$user->email = $email;
		if (Input::has('photo_url')) {
			$user->photo = Input::get('photo_url');
		}
		$user->notify_email = $notifications;
		$user->save();
		return Redirect::to('user/preferences')
			->with_message("Your preferences have been saved!", 'success');

	}

	public function get_forgot_password() {
		return View::make('user.forgot');
	}
	
	public function post_forgot_password() {
		    // Reset the password
		    if ($reset = Sentry::reset_password(Input::get('email'), Input::get('password'))) {
		        $email = $reset['email'];
		        $link = URL::to('confirm/'.$reset['link']); // adjust path as needed
				$html = "<h2>Did you want to reset your password?</h2><p>Looks like someone wanted to reset your password.  If you do, please click <a href='".$link."'>here</a></p><p>Thanks,<br/>Team Queso</p>";
			
				Message::send(function($message) use ($email, $html) {
				    $message->to($email);
				    $message->from('info@conque.so', 'Queso Information');
				    $message->subject("Password Reset");
			    	$message->body($html);
			    	$message->html(true);
					});
			}
		return View::make('user.sent');
	}

	public function get_confirm($hashed_email, $confirmation_code) {
		try {
		    // Confirm the user password reset code
		    $confirm_reset = Sentry::reset_password_confirm($hashed_email, $confirmation_code);


		    if ($confirm_reset)
		    {
		    	return View::make('user.confirm');
		        // User password was successfully changed
		    }
		    else
		    {
		    	return View::make('user.not_confirmed');
		        // There was a problem confirming the password reset code
		    }
		}
		catch (Sentry\SentryException $e) {
		    $errors = $e->getMessage();
		}		
	}

}
