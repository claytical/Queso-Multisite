<?php

// User controller is responsible for showing logged in user's profile, posting a critt and following/unfollowing other users

class Quest_Controller extends Base_Controller {

	// Since we will use get and post, we need to make controller to be RESTful.
	public $restful = true;

	// Attach an Auth filter to every route in this controller to make sure the user is logged in
	public function __construct(){
		//$this->filter('before', 'auth');
	}
	
	/*
		*	CREATE QUESTS
		*
	*/ 

	public function get_create() {

		$skills = Skill::where('group_id', '=', Session::get('current_course'));
		$levels = Level::where('group_id', '=', Session::get('current_course'))
				->order_by('amount', 'asc')->lists('label', 'amount');
		if ($levels) {

			$categories = DB::table('quests')
							->where('group_id', '=', Session::get('current_course'))
							->distinct('category')
							->get('category');

			$quest = array(
					'types' => DB::table('quest_types')->lists('label','id'),
					'skills' => $skills->lists('name', 'id'),
					'levels' => $levels,
					'categories' => $categories);
			
				return View::make('quests.create')
				->with('quest', $quest);
		}
		else {
		return Redirect::to('admin/levels')
				->with_message('You need to create levels first!', 'error');

		}
	}
	
	public function post_create() {
		//create quest

			$quest = Quest::create(
				array('name' => Input::get('title'),
					  'instructions' => Input::get('body'),
					  'type' => Input::get('type'),
					  'category' => Input::get('category'),
					  'filename' => Input::get('files'),
					  'allow_upload' => Input::has('allow_upload'),
					  'allow_text' => Input::has('allow_text'),
					  'visible' => 1,
					  'position' => 0,
					  'group_id' => Session::get('current_course')
					  ));	
			//insert skill amounts
			foreach (Input::get('skill_reward') as $key => $skill_reward) {
				$i = 0;
				foreach ($skill_reward['label'] as $reward) {
					DB::table('quest_skill')->insert(
							array('quest_id' => $quest->id,
								  'skill_id' => $key,
								  'label' => $reward,
								  'amount' => $skill_reward['amount'][$i])
								  );
					$i++;
				}
			}	
			
			
			//insert thresholds for quest
			
			foreach (Input::get('threshold_skill_level') as $key => $threshold) {
					DB::table('quest_lock')->insert(
							array('quest_id' => $quest->id,
								  'skill_id' => $key,
								  'requirement' => $threshold[0])
								  );
			
			
			}
			$quest->dump = Input::get();
		return View::make('quests.created')->with('quest', $quest);
	}

	public function get_clone($id) {
		$quest = Quest::find($id);
		return View::make('quests.clone')->with('quest', $quest);

	}

	public function post_clone() {
		$questToClone = Quest::find(Input::get('quest_id'));
			$quest = Quest::create(
				array('name' => Input::get('title'),
					  'instructions' => Input::get('body'),
					  'type' => $questToClone->type,
					  'category' => $questToClone->category,
					  'filename' => $questToClone->filename,
					  'allow_upload' => $questToClone->allow_upload,
					  'allow_text' => $questToClone->allow_text,
					  'visible' => 1,
					  'position' => 0,
					  'group_id' => Session::get('current_course')
					  ));	
			//insert skill amounts
			$skills = DB::table('quest_skill')->where('quest_id', '=', Input::get('quest_id'))->get();

			foreach ($skills as $skill) {
				DB::table('quest_skill')->insert(
						array('quest_id' => $quest->id,
							  'skill_id' => $skill->skill_id,
							  'label' => $skill->label,
							  'amount' => $skill->amount)
						);
			}
			
			$locks = DB::table('quest_lock')->where('quest_id', '=', Input::get('quest_id'))->get();

			foreach ($locks as $lock) {
				DB::table('quest_lock')->insert(
							array('quest_id' => $quest->id,
								  'skill_id' => $lock->skill_id,
								  'requirement' => $lock->requirement)
							);
			}			

		return View::make('quests.cloned')->with('quest', $quest);

	}

	public function get_update($id) {
		$quest = new stdClass();
		$questInfo = Quest::find($id);
		$all_skills = Skill::where('group_id', '=', Session::get('current_course'))
								->lists('name', 'id');
		$levels = Level::where('group_id', '=', Session::get('current_course'))
						->order_by('amount', 'asc')->lists('label', 'amount');
		$locks = DB::table('quest_lock')
					->where('quest_id', '=', $id)
					->lists('requirement', 'skill_id');
		$quest->name = $questInfo->name;
		$quest->instructions = $questInfo->instructions;
		$quest->id = $questInfo->id;
		$quest->category = $questInfo->category;
		$quest->levels = $levels;
		$quest->all_skills = $all_skills;
		$quest->locks = $locks;
		$encoded_files = explode(",", $questInfo->filename);

		foreach($encoded_files as $file) {
			if (!empty($file)) {
				$quest->files[] = array("encoded" => $file,
								 "friendly" => Filepicker::metadata($file)->filename);
			}
		}
		
		foreach($questInfo->skills()->lists('name', 'id') as $skill_id => $skill) {
			$quest->skills[$skill_id] = array('name' => $skill,
									 	'rewards' => DB::table('quest_skill')
									 						->where('skill_id', '=', $skill_id)
									 						->where('quest_id', '=', $id)
									 						->get());
		}
		
		
		return View::make('quests.update')->with('quest', $quest);
	}
	
	public function post_update() {
			$quest = Quest::find(Input::get('quest_id'));
			$quest->name = Input::get('title');
			$quest->instructions = Input::get('instructions');
			$quest->category = Input::get('category');
			if (Input::get('existingFiles') && Input::get('files')) {
				$existingFiles = Input::get('existingFiles');
				$newFiles = explode(",", Input::get('files'));
				$quest->filename = implode(",", array_merge($newFiles, $existingFiles));		
			}
			else if (Input::get('files')) {
				$quest->filename = Input::get('files');
			}

			$quest->save();

		DB::table('quest_skill')->where('quest_id', '=', Input::get('quest_id'))
								->delete();
		//insert updated skill amounts
		foreach (Input::get('skill_reward') as $key => $skill_reward) {
			$i = 0;
			foreach ($skill_reward['label'] as $reward) {
				DB::table('quest_skill')->insert(
						array('quest_id' => $quest->id,
							  'skill_id' => $key,
							  'label' => $reward,
							  'amount' => $skill_reward['amount'][$i])
							  );
				$i++;
			}
		}
		
		DB::table('quest_lock')
			->where('quest_id', '=', Input::get('quest_id'))
			->delete();
			
		foreach (Input::get('threshold_skill_level') as $key => $threshold) {
			DB::table('quest_lock')->insert(
				array('quest_id' => Input::get('quest_id'),
					  'skill_id' => $key,
					  'requirement' => $threshold[0])
					  );


		}
		
		return Redirect::to('admin/quests')
				->with_message(Input::get('title') . " has been updated!", 'success');

	}

	public function get_hide($id) {
		$quest = Quest::find($id);
		if ($quest->group_id == Session::get('current_course')) {
			$quest->visible = FALSE;
			$quest->save();
		}
		
		return Redirect::to('admin/quests');

	}

	public function get_show($id) {
		$quest = Quest::find($id);
		if ($quest->group_id == Session::get('current_course')) {
			$quest->visible = TRUE;
			$quest->save();
		}
		
		return Redirect::to('admin/quests');

	}
	

	public function get_remove($id) {
		$quest = Quest::find($id);
		if ($quest->group_id == Session::get('current_course')) {
			$submissions = Submission::where('quest_id', '=', $quest->quest_id);
			$submissions->delete();

			DB::table('quest_lock')
				->where('quest_id', '=', $quest->id)
				->delete();
			DB::table('quest_skill')
				->where('quest_id', '=', $quest->id)
				->delete();
			DB::table('quest_user')
				->where('quest_id', '=', $quest->id)
				->delete();
			DB::table('skill_user')
				->where('quest_id', '=', $quest->id)
				->delete();
			$quest->delete();
		}
		
		return Redirect::to('admin/quests')
				->with_message($quest->name. " has been deleted!", 'info');


	}


	
	/*
	*	ALL AVAILABLE QUESTS FOR USER
	*
	*/ 

	public function get_index($id = NULL) {

		//Get Completed Quests
		if ($id == NULL) {
			$id = Session::get('uid');
		}
		$categories = DB::table('quests')
                        ->where('group_id', '=', Session::get('current_course'))
                        ->distinct('category')
                        ->lists('category');;
        array_unshift($categories, "All Categories");

		$playerQuests = User::find($id)->quests();
		$ids = $playerQuests->lists('id');
		if (!empty($ids)) {
			$quests = Group::find(Session::get('current_course'))
				->quests()
				->where_not_in('id',$ids);			
		}
		else {
			$quests = Group::find(Session::get('current_course'))
			->quests();
		
		}

		if ($quests->get()) {

			foreach($quests->get() as $quest) {
				$quest = Merge::max_skill_points($quest);
				$questsWithPoints[] = $quest;

			}
		}
		else {
			$questsWithPoints = NULL;
		}


			$view = View::make('quests.index')
			->with('data', array('quests' => $questsWithPoints, 
								 'title' => 'Available Quests',
								 'categories' => $categories)
				
			);
		
		return $view;

	}
	public function get_grade_in_class() {
		$quests = Group::find(Session::get('current_course'))->quests()
						->where('type', '=', 1);
        $categories = DB::table('quests')
                        ->where('group_id', '=', Session::get('current_course'))
                        ->where('type', '=', 1)
                        ->distinct('category')
                        ->lists('category');
        
        $data = array('quests' => $quests->get(),
                      'categories' => $categories,
					  'title' => 'Grade In Class Quests'
					  );
		
		return View::make('quests.class')
			->with('data', $data);

	}
	
	public function get_grade($id) {
		$data = new stdClass();
		$quest = Quest::find($id);
		$data->quest = $quest;
		$user_ids = $quest->users()->lists('id');
		$data->students = Group::find(Session::get('current_course'))
								->users()
								->where('active', '=', 1)
//								->where_not_in('user_id', $user_ids)
								->order_by('username', 'asc')
								->lists('username', 'id');
		foreach($data->quest->skills()->lists('name', 'id') as $key => $skill) {
			$data->skills[] = array('id' => $key,
								  'name' => $skill,
								  'rewards' => DB::table('quest_skill')
								  				->where('quest_id', '=', $id)
								  				->where('skill_id', '=', $key)
								  				->order_by('amount', 'asc')
								  				->lists('amount', 'label'));
		}

				
		return View::make('quests.grade')
			->with('data', $data);
	
	}
	
	public function post_grade() {
		//add to quest_user
		foreach(Input::get('students') as $student) {
			$quest = User::find($student)->quests()->where('quest_id', '=', Input::get('quest_id'))->first();
			if ($quest) {
				//update quest
				DB::table('quest_user')
					->where('quest_id', '=', Input::get('quest_id'))
					->where('user_id', '=', $student)
					->update(array('note' => Input::get('note'),
								   'updated_at' => DB::raw('NOW()')));
			}
			else {
			//insert new quest
				DB::table('quest_user')->insert(
										array('quest_id' => Input::get('quest_id'),
											  'user_id' => $student,
											  'note' => Input::get('note'),
											  'created_at' => DB::raw('NOW()'),
											  'updated_at' => DB::raw('NOW()')
											  ));

			}
			
			//add to skill_user
			DB::table('skill_user')
					->where('user_id', '=', $student)
					->where('quest_id', '=', Input::get('quest_id'))
					->delete();					
						
			foreach (Input::get('grade') as $skill_id => $grade) {
				DB::table('skill_user')->insert(
											array('user_id' => $student,
												  'quest_id' => Input::get('quest_id'),
												  'group_id' => Session::get('current_course'),
												  'skill_id' => $skill_id,
												  'amount' => $grade,
												  'created_at' => DB::raw('NOW()'),
												  'updated_at' => DB::raw('NOW()')
												)
											);							
			}
			
			$notice = new Notice;
			$notice->user_id = $student;
			$notice->group_id = Session::get('current_course');
			$notice->notification = "<p>".Input::get('note')."</p>";
			$quest = Quest::find(Input::get('quest_id'));
			$notice->title = $quest->name . " has been graded";
			$notice->url = "quests/completed#".Input::get('quest_id');
			$notice->save();
			$message = "For more information, visit <a href='".URL::to($notice->url)."'>the class website</a>";
			Info::notify($student, $notice->title, $message);

		}
		return Redirect::to('admin/grade')
			->with_message($quest->name . " has been graded!", 'success');


	}
	/*
	*	ALL AVAILABLE QUESTS FOR USER
	*
	*/ 
    
    public function get_available($id = NULL) {
		//Get Completed Quests
		$admin = FALSE;
		$title = "Available Quests";
		if ($id == NULL) {
			$id = Session::get('uid');
			$admin = TRUE;
		}
		else {
			$student = User::find($id)->email;
			$title = $title . " for " . $student;
		
		}		
		
		$playerQuests = User::find($id)->quests();
		$ids = $playerQuests->lists('id');
        
        $categories = DB::table('quests')
                        ->where('group_id', '=', Session::get('current_course'))
                        ->distinct('category')
                        ->lists('category');;
        array_unshift($categories, "All Categories");
        if (!empty($ids)) {
			$quests = Group::find(Session::get('current_course'))
				->quests()
				->where_not_in('id',$ids);
		}
		else {
			$quests = Group::find(Session::get('current_course'))
			->quests();
		
		}

        if ($quests->get()) {

			foreach($quests->get() as $quest) {
				$quest = Merge::max_skill_points($quest);
				$questsWithPoints[] = $quest;

			}
		}
		else {
			$questsWithPoints = NULL;
		}
           // $questsWithPoints['categories'] = $categories;


			$view = View::make('quests.index')
			->with('data', array('admin' => $admin, 
								 'quests' => $questsWithPoints,
                                 'categories' => $categories,
								 'title' => $title)
				
			);

        return $view;
        
    }

	public function get_available_online() {

		//Get Completed Quests
		$playerQuests = User::find(Session::get('uid'))->quests();
		$ids = $playerQuests->lists('id');
        if (!empty($ids)) {
			$quests = Group::find(Session::get('current_course'))
				->quests()
				->where_not_in('id',$ids)
				->where('type', '>', 1);			
		}
		else {
			$quests = Group::find(Session::get('current_course'))
			->quests()
			->where('type', '>', 1);
		
		}
		if ($quests->get()) {

			foreach($quests->get() as $quest) {
				$quest = Merge::max_skill_points($quest);
				$questsWithPoints[] = $quest;

			}
		}
		else {
			$questsWithPoints = NULL;
		}
			$view = View::make('quests.index')
			->with('data', array('quests' => $questsWithPoints,
								 'title' => 'Online Quests')
				
			);
		
		return $view;

	}


	public function get_available_in_class() {
		//Get Uncompleted Quests
		$playerQuests = User::find(Session::get('uid'))->quests();
		$ids = $playerQuests->lists('id');
		if (!empty($ids)) {
			$quests = Group::find(Session::get('current_course'))
				->quests()
				->where_not_in('id',$ids)
				->where('type', '<', 2);			
		}
		else {
			$quests = Group::find(Session::get('current_course'))
			->quests()
			->where('type', '<', 2);
		
		}
		if ($quests->get()) {
			foreach($quests->get() as $quest) {
				$quest = Merge::max_skill_points($quest);
				$questsWithPoints[] = $quest;

			}
		}
		else {
			$questsWithPoints = NULL;
		}
			$view = View::make('quests.index')
			->with('data', array('quests' => $questsWithPoints,
								 'title' => 'In Class Quests')
				
			);
		
		return $view;
		
	}

	public function post_remove_skills() {
	
		$quest_skills = Input::get('removeSkill');
		foreach($quest_skills as $skill) {
			DB::table('quest_skill')
				->where('id', '=', $skill)
				->delete();
		}
		
		return Redirect::to('admin/skills/quest/'.Input::get('quest_id'))
				->with_message("Deleted skill quest " . implode($quest_skills, ","), 'success');


	}
	
	public function get_quest_skills($id) {
		$data = new stdClass();
		$quest = Quest::find($id);

		//get the skills for the quest
		$skills = DB::table('quest_skill')
						->where('quest_id', '=', $quest->id)
						->order_by('skill_id')
						->lists('skill_id');
		//deduplicate the skills
		$skills = array_unique($skills);

		//get the info for each skill
		foreach($skills as $skill) {
			$name = Skill::where('id', '=', $skill)
											->first()
											->name;
			$questSkills = DB::table('quest_skill')
							->where('quest_id', '=', $quest->id)
							->where('skill_id', '=', $skill)
							->get();
							
			foreach($questSkills as $value) {
				$data->skills[] = array('name' => $name,
										'id' => $value->id,
										'label' => $value->label,
										'amount' => $value->amount);
													
			}
		}
											

		$data->quest = $quest;
		return View::make('quests.questskills')
			->with('data', $data);
	}
	/*
	*	ALL QUESTS FOR COURSE
	*
	*/ 

	public function get_all() {
		$quests = Group::find(Session::get('current_course'))
					->quests()
					->get();

		if ($quests->get()) {
			foreach($quests->get() as $quest) {
				$quest = Merge::max_skill_points($quest);
				$questsWithPoints[] = $quest;

			}
		}
		else {
			$questsWithPoints = NULL;
		}		
		return View::make('quests.index')
			->with('quests', $questsWithPoints);
	
	}


	/*
	*	QUESTS COMPLETED BY USER
	*
	*/ 



	public function get_completed_by_student() {
		$data = new stdClass();
		//list of quests completed
		
		
		$completed_quests = User::find(Session::get('uid'))
							  ->quests()
							  ->where('group_id', '=', Session::get('current_course'));
		
		//quest categories for completed quests

		$data->categories = array_unique($completed_quests->lists('category'));
        array_unshift($data->categories, "All Categories");

        if(($key = array_search("", $data->categories)) !== false) {
			   unset($data->categories[$key]);
		}
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
										->where('user_id', '=', Session::get('uid'))
										->where('group_id', '=', Session::get('current_course'))
										->where('skill_id', '=', $skill->id)
										->sum('amount'));
		
		}

		//student quests with skills acquired
		if ($completed_quests->count() == 0) {
			$data->quests = array();
		}
		foreach ($completed_quests->get() as $quest) {
			switch ($quest->type) {
				case 1:
					$submission = FALSE;
				break;

				case 2:
					$submission = Submission::where('quest_id', '=', $quest->quest_id)
											->where('user_id', '=', Session::get('uid'))
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
										->where('user_id', '=', Session::get('uid'))
										->where('skills.group_id', '=', Session::get('current_course'))
										->where('quest_id', '=', $quest->quest_id)
										->get());
		}
		
		//loop through quests, questid = key
		//order by amount, get first
		//$completed_quests->has_many('Skill')->get();
		
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
			}
		
		return View::make('quests.completed')
					->with('data', $data);
	
	}



	/*
	*	QUEST ATTEMPT
	*	
	*	get - details
	*	post - submit
	*/ 

	public function get_attempt($id) {
		return View::make('quests.attempt')
			->with('quest', Quest::find($id));
	
	}
	
	public function post_attempt() {
		if(Input::has('revision')) {
			$revision = Input::get('revision');
			$previous_attempts = Submission::where('user_id', '=', Session::get('uid'))
								->where('quest_id', '=', Input::get('quest_id'));
			$previous_attempts->update(array('graded' => TRUE));

		}
		else {
			DB::table('quest_user')->insert(
									array('quest_id' => Input::get('quest_id'),
										  'user_id' => Session::get('uid'),
										  'created_at' => DB::raw('NOW()'),
										  'updated_at' => DB::raw('NOW()')
										  ));
			$revision = 0;		
		}
		$quest = Quest::find(Input::get('quest_id'));
		$user = User::find(Session::get('uid'));
		//find instructors
		$instructors = DB::table('users_groups')
						->where('group_id', '=', Input::get('group_id'))
						->where('instructor', '=', 1)
						->lists('user_id');

		if (Input::get('quest_type') == 2) {
			//written submission
			$attempt = Submission::create(
				array('submission' => Input::get('body'),
					  'filename' => Input::get('files'),					
					  'user_id' => Session::get('uid'),
					  'quest_id' => Input::get('quest_id'),
					  'group_id' => Input::get('group_id'),
					  'visible' => Input::has('visible'),
					  'revision' => $revision
					  ));	


			foreach ($instructors as $instructor) {
				$notice = new Notice;
				$notice->url = "admin/submission/grade/".$attempt->id;

				if ($revision > 0) {
					$notice->title = "[Revision] ".$quest->name;
					$notice->notification = "<p>".$user->username." has revised ".$quest->name."</p>";

				}
				else {
					$notice->title = "[Submission] ".$quest->name;
					$notice->notification = "<p>".$user->username." has completed ".$quest->name."</p>";
				}
					$notice->user_id = $instructor;
					$notice->group_id = Session::get('current_course');
					$notice->save();
					$message = $notice->notification . "<p>For more information, visit <a href='".URL::to($notice->url)."'>the class website</a></p>";
					Info::notify($instructor, $notice->title, $message);

			}
				return Redirect::to('submission/view/'.$attempt->id);
			}
		
	}


	
	public function get_details($id) {
		return View::make('quest.details')
			->with('quest', Quest::find($id));
	
	}
	
	public function get_completed_by($id) {
		$quest = Quest::find($id);
		$users = $quest->users()->get();
		$ids = $quest->users()->lists('id');

		$data = new stdClass();
		$data->quest = $quest;
		//quest skills

		$skills = $quest->skills()->lists('name', 'id');
		$skills = array_unique($skills);
		
		foreach ($skills as $key => $skill) {
			$data->skills[$skill] = DB::table('quest_skill')
						->where('quest_id', '=', $id)
						->where('skill_id', '=', $key)
						->max('amount');
		}
		
		foreach($users as $user) {
			//look up skills for user completing quest
			foreach ($skills as $skill_id => $skill) {
				$amount = DB::table('skill_user')
											->where('user_id', '=', $user->id)
											->where('skill_id', '=', $skill_id)
											->where('quest_id', '=', $id)
											->sum('amount');
				if (!empty($amount)) {
					$acquired_skill[] = array('label' => $skill,
										  'amount' => $amount);
					
					}
				}
				if (isset($acquired_skill)) {
					$data->completed_users[] = array('username' => $user->username,
													'id' => $user->id,
											 		'submission' => Submission::where('quest_id', '=', $id)
											 						->where('user_id', '=', $user->id)
											 						->order_by('created_at', 'desc')
											 						->first(),
													'skills' => $acquired_skill);
								   
				unset($acquired_skill);
			}
			else {
				$data->completed_users[] = array('username' => $user->username,
												'id' => $user->id,
											 	'submission' => Submission::where('quest_id', '=', $id)
											 	->where('user_id', '=', $user->id)
											 	->order_by('created_at', 'desc')
											 	->first(),
											   'skills' => NULL);
			
			}
		}
		if (empty($data->completed_users)) {
			$data->completed_users = NULL;
		}

		if (empty($ids)) {
		$data->available_users = Group::find(Session::get('current_course'))
				->users()
				->get();
		}
		else {
		$data->available_users = Group::find(Session::get('current_course'))
				->users()
				->where_not_in('user_id', $ids)
				->get();
		}
		return View::make('quests.completion')
			-> with('data',$data);
	
	}
	
	
	public function get_admin() {
		$data = new stdClass();
		$quests = Group::find(Session::get('current_course'))
						->quests();
		$data->quests = $quests->get();
		$data->categories = array_unique($quests->lists('category'));
		if(($key = array_search("", $data->categories)) !== false) {
			   unset($data->categories[$key]);
		}

		return View::make('quests.admin')
			->with('data', $data);
	
	}





}

?>