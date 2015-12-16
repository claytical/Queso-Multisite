<?php

class Course_Controller extends Base_Controller {
	public $restful = TRUE;
	
	public function get_index() {
		$data = new stdClass();
		$groups = Group::all();
		$data->courses = array();
		foreach($groups as $group) {
			$instructors = $group->users()->where('instructor', '=', 1)->get();

			$data->courses[] = array("class" => $group, "instructors" => $instructors);
		}

		return View::make('courses.index')
					->with('data', $data);
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
        $data->code = $course->code;
		$data->id = $course->id;
		$data->public = $course->public;
		$data->active = $course->active;
		$dropdown = $course->variables()->where('label', '=', 'dropdown')->first();
		if ($dropdown) {
			$data->dropdown = $dropdown->variable;
		}
		else {
			$data->dropdown = 'Posts';
		}
		$data->alert = NULL;
		
		$skills = Skill::where('group_id', '=', Session::get('current_course'))->order_by('name', 'asc')->get();
        $data->skills = $skills; 
        
		$levels = Level::where('group_id', '=', Session::get('current_course'))->order_by('amount', 'asc');
        $data->levels = $levels->get();

		$teams = Team::where('group_id', '=', Session::get('current_course'))->order_by('label', 'asc')->get();
        $data->teams = $teams;
	        
       // $sections = Section::where('group_id', '=', Session::get('current_course'))->order_by('name', 'asc');
       // $data->sections = $sections->get();
        return View::make('courses.all')
		->with('course', $data);
	}

	public function post_setup() {
		$course = Group::find(Session::get('current_course'));
		$course->name = Input::get('course');
        $course->code = Input::get('code');
        $course->active = Input::get('active');
        $course->public = Input::get('public');
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
        $data->code = $course->code;
		$data->id = $course->id;
		$dropdown = $course->variables()->where('label', '=', 'dropdown')->first();
		if ($dropdown) {
			$data->dropdown = $dropdown->variable;
		}
		else {
			$data->dropdown = 'Posts';
		}

        $data->alert = "Course information has been updated!";

        if (Input::has('tab')) {
            return Redirect::to('admin/course#general')
					->with_message($data->alert, 'success');    
        }
        else {
            return View::make('courses.setup')
		  ->with('course', $data);

        }
	
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
		if (array_get(Input::file('course_file'), 'tmp_name'))
		{
		    
		    // file uploaded
		    $import = TRUE;
		    $renamed = FALSE;
			$json = file_get_contents(Input::file('course_file.tmp_name'));
			$course_to_import = json_decode($json);

			try {
				$course_id = Sentry::group()->create(array('name'=> $course_to_import->name));
				
			} catch (Exception $e) {
				$new_code = Course::generate_code();
				$renamed = TRUE;
				$course_id = Sentry::group()->create(array('name'=> $course_to_import->name . $new_code));								
			}
			 

		}

		else {
			$import = FALSE;
			$course_data = array('name' => Input::get('course'));

			try {
				$course_id = Sentry::group()->create($course_data);
			}
			catch (Exception $e) {
				return Redirect::to('course/new')
					->with_message("That course already exists, perhaps you should try something else.", 'error');
					
			}
		
		}

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
	    $user_id = intval(Session::get('uid'));
		$user = Sentry::user($user_id);
	    if ($user->add_to_group($course_id)) {
	        // Group assigned successfully
	    		DB::table('users_groups')
	    			->where('user_id', '=', Session::get('uid'))
	    			->where('group_id', '=', $course_id)
	    			->update(array('instructor' => 1));
	    			
				Session::put('current_course', $course_id);
				Session::put('course_name', $course->name);

				if ($import) {
					//import levels
					foreach($course_to_import->levels as $level => $amount) {
						Level::create(array('label' => $level,
											'amount' => $amount,
											'group_id' => $course_id));
					}

					//create old skill id map to new skill ids
					$skill_map = array();
					//import skills
					
					foreach($course_to_import->skills as $skill) {
						$new_skill = Skill::create(array('name' => $skill->name,
														 'group_id' => $course_id));
						$skill_map[$skill->mapped_id] = $new_skill->id;

					}

					//import quests

					foreach($course_to_import->quests as $quest) {
						$new_quest = Quest::create(
										array('name' => $quest->name,
											  'instructions' => $quest->instructions,
											  'type' => $quest->type,
											  'category' => $quest->category,
											  'filename' => $quest->filename,
											  'allow_upload' => $quest->allow_upload,
											  'allow_text' => $quest->allow_text,
											  'visible' => $quest->visible,
											  'position' => $quest->position,
											  'group_id' => $course_id)
											  );
						
						foreach($quest->skills as $quest_skills) {
							DB::table('quest_skill')->insert(
									array('quest_id' => $new_quest->id,
										  'skill_id' => $skill_map[$quest_skills->mapped_id],
										  'label' => $quest_skills->label,
										  'amount' => $quest_skills->amount)
										  );
						}
						
						foreach($quest->locks as $quest_locks) {
							DB::table('quest_lock')->insert(
									array('quest_id' => $new_quest->id,
										  'skill_id' => $skill_map[$quest_locks->mapped_id],
										  'requirement' => $quest_locks->amount)
										  );							
						}


					}
					Variable::create(
						array('variable' => $course_to_import->dropdown,
							  'label' => 'dropdown',
							  'group_id' => $course_id)
							  );
					if ($renamed) {
						return Redirect::to('admin/course')
							->with_message("Course has been imported, but the course name is taken.  We took some liberty and added junk on the end.  Feel free to rename it.", 'warning');
					}
					else {
						return Redirect::to('admin/course')
							->with_message("Course has been imported!", 'success');

					}
				}
				else {
					return Redirect::to('admin/skills')
					->with_message(Input::get('course') . " has been created!", 'success');
				;
			}

	    }

	}

	public function get_public() {
		$user_groups = User::find(Session::get('uid'))->groups();
		$ids = $user_groups->lists('id');
		
		if (!empty($ids)) {
			$courses = Group::where('public', '=', 1)
							->where_not_in('id', $ids)
							->get();		
		}
		else {
			$courses = Group::where('public', '=', 1)->get();	
		}

		return View::make('courses.public')
				->with('courses', $courses);

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

	public function get_export() {
		$exported_course = new stdClass();
		//variables

	   	$course = Group::find(Session::get('current_course'));
		$exported_course->name = $course->name;
		$dropdown = $course->variables()->where('label', '=', 'dropdown')->first();
		if ($dropdown) {
			$exported_course->dropdown = $dropdown->variable;
		}
		else {
			$exported_course->dropdown = "Posts";
		}
		//levels
		$levels = $course->levels()->get();

		foreach($levels as $level) {
			$exported_course->levels[$level->label] = $level->amount;
		}

		//skills
		$skills = $course->skills()->get();

		foreach($skills as $skill) {
			$exported_course->skills[] = array('name' => $skill->name,
											   'mapped_id' => $skill->id);
		}
		//quests

		$quests = $course->quests()->get();

		foreach($quests as $quest) {
			$quest_skills = DB::table('quest_skill')
								->where('quest_id', '=', $quest->id)
								->get();

			foreach($quest_skills as $skill) {
				$q_skills[] = array('mapped_id' => $skill->skill_id,
									'label' => $skill->label,
									'amount' => $skill->amount);
			}


			$quest_locks = DB::table('quest_lock')
					->where('quest_id', '=', $quest->id)->get();
			$locks = array();
			foreach($quest_locks as $quest_lock) {
					$locks[] = array('mapped_id' => $quest_lock->skill_id,
									 'amount' => $quest_lock->requirement);
			}

			$exported_course->quests[] = array('name' => $quest->name,
											   'instructions' => $quest->instructions,
											   'type' => $quest->type,
											   'category' => $quest->category,
											   'allow_upload' => $quest->allow_upload,
											   'allow_text' => $quest->allow_text,
											   'visible' => $quest->visible,
											   'filename' => $quest->filename,
											   'position' => $quest->position,
											   'locks' => $locks,
											   'skills' => $q_skills
											   );
			unset($q_skills);
		}
		$json = json_encode($exported_course);
		$headers = array( 'Content-Type' => 'application/json', 'Content-Disposition' => 'attachment;filename='.str_replace(" ", "", $course->name).'.json');
  
		return Response::make($json, 200, $headers );
	
	}

	public function get_course($id) {
		try {
		// check to see if the current user is in the editors(id:2) group
			if (Sentry::user()->in_group($id)) {
				// user is in the group
				$group = Group::find($id);
				Session::put('current_course', $id);
				Session::put('course_name', $group->name);
				return Redirect::to('posts');

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