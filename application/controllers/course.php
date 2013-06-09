<?php

class Course_Controller extends Base_Controller {
	public $restful = TRUE;
	
	public function get_index() {
		$user = User::find(Session::get('uid'));
		if ($user->super) {
			return View::make('courses.index')
						->with('courses', Group::all());
			}
		else {
			return Redirect::to('/');
		}
	}

	public function get_remove($id) {

		Group::find($id)->delete();
		Variable::where('group_id', '=', $id)->delete();
		Level::where('group_id', '=', $id)->delete();
		Notice::where('group_id', '=', $id)->delete();
		Post::where('group_id', '=', $id)->delete();
		Submission::where('group_id', '=', $id)->delete();
		Skill::where('group_id', '=', $id)->delete();
		
		DB::table('skill_user')
				->where('group_id', '=', $id)->delete();

		DB::table('users_groups')
			->where('group_id', '=', $id)->delete();
		
		$questions = Question::where('group_id', '=', $id);

		foreach($questions->get() as $question) {
			Answer::where('question_id', '=', $question->id)->delete();
		}

		$questions->delete();

		$quests = Quest::where('group_id', '=', $id);

		foreach($quests->get() as $quest) {
			Comment::where('quest_id', '=', $quest->id)->delete();
			DB::table('quest_lock')
				->where('quest_id', '=', $quest->id)
				->delete();
			DB::table('quest_skill')
				->where('quest_id', '=', $quest->id)
				->delete();
			DB::table('quest_user')
				->where('quest_id', '=', $quest->id)
				->delete();
		}

		$quests->delete();
		return View::make('courses.index')
					->with('courses', Group::all());

	}
	public function get_setup() {
		$course = Group::find(Session::get('current_course'));
		$data = new stdClass();
		$data->name = $course->name;
		$data->id = $course->id;
		$dropdown = $course->variables()->where('label', '=', 'dropdown')->first();
		if ($dropdown) {
			$data->dropdown = $dropdown->variable;
		}
		else {
			$data->dropdown = 'Posts';
		}
		$data->alert = NULL;
		return View::make('courses.setup')
		->with('course', $data);
	}

	public function post_setup() {
		$course = Group::find(Session::get('current_course'));
		$course->name = Input::get('course');
		Session::put('course_name', $course->name);
		$course->save();
		if (Input::has('dropdown')) {
			$dropdown = $course->variables()->where('label', '=', 'dropdown');
			if ($dropdown->count() == 0) {
				//make new variable
				$dropdown = Variable::create(
					array('variable' => Input::get('dropdown'),
					  'label' => 'dropdown',
					  'group_id' => Session::get('current_course')
					  ));
		
			}
			else {
				//update existing variable
				$dropdown = $dropdown->first();
				$dropdown->variable = Input::get('dropdown');
				$dropdown->save();
	
			}
		}
		$data = new stdClass();
		$data->name = $course->name;
		$data->id = $course->id;
		$dropdown = $course->variables()->where('label', '=', 'dropdown')->first();
		if ($dropdown) {
			$data->dropdown = $dropdown->variable;
		}
		else {
			$data->dropdown = 'Posts';
		}		
		$data->alert = "Course information has been updated!";
		return View::make('courses.setup')
		->with('course', $data);
	
	}

	public function get_share() {
		return View::make('courses.share');
	}

	public function post_share() {
		$emails = explode(",", Input::get('emails'));		
		$registration_url = URL::to('register?id='.Course::code());
		$html = "<h2>Hello!</h2><p>You've been invited to sign up for a class that's running on Queso.  Please register for the class by <a href='".$registration_url."'>clicking here</a></p><p>Thanks,<br/>Team Queso</p>";

		foreach($emails as $email) {
			Message::send(function($message) use ($email, $html) {
			    $message->to($email);
			    $message->from('info@conque.so', 'Queso Information');
			    $message->subject('You\'ve been invited to '. Session::get('course_name'));
			    $message->body($html);

			    // You can add View data by simply setting the value
			    // to the message.

			    $message->html(true);
			});
		}
		return View::make('courses.shared');


	}
	public function get_create() {
		return View::make('courses.new');

	}

	public function post_create() {
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
		$user = Sentry::user(Session::get('uid'));
	    if ($user->add_to_group($course_id)) {
	        // Group assigned successfully
	    		DB::table('users_groups')
	    			->where('user_id', '=', Session::get('uid'))
	    			->where('group_id', '=', $course_id)
	    			->update(array('instructor' => 1));
	    			
				Session::put('current_course', $course_id);
				Session::put('course_name', Input::get('course'));
				return Redirect::to('admin/skills')
					->with_message(Input::get('course') . " has been created!", 'success');
				;

	    }

	}

	public function get_generate() {

		return View::make('courses.generate')
				->with('courses', DB::table('groups')->lists('name', 'id'));
	}

	public function post_generate() {
	    $course = Group::find(Input::get('course'));
	    $codeNeedsRefresh = TRUE;
	    while ($codeNeedsRefresh) {
		    $code = Course::generate_code();	    	
			if(Group::where('code', '=', $code)->count() == 0) {
				$course->code = $code;
				$codeNeedsRefresh = FALSE;
			}
	    }

	    $course->save();
		return Redirect::to('admin/course/generate');

	}
	public function get_course($id) {
		try {
		// check to see if the current user is in the editors(id:2) group
			if (Sentry::user()->in_group($id)) {
				// user is in the group
				$group = Group::find($id);
				Session::put('current_course', $id);
				Session::put('course_name', $group->name);
			//	return View::make('courses.switch');
				return Redirect::to('/');

			}
			else {
				// user is not in the group
				return View::make('courses.notallowed');

			}
		}

		catch (Sentry\SentryException $e) {
			$errors = $e->getMessage(); // catch errors such as user does not exist.
		}

	
	}
}