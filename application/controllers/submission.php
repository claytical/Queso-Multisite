<?php


class Submission_Controller extends Base_Controller {

	// Since we will use get and post, we need to make controller to be RESTful.
	public $restful = true;

	// Attach an Auth filter to every route in this controller to make sure the user is logged in
	public function __construct(){
		//$this->filter('before', 'auth');
	}
	

	public function get_index() {
	//get session for course
	
		return View::make('submissions.index')
		->with('submissions', Submission::all()
		->where('visible', '=', 1)
		->get());
	
	}
	public function get_view($id) {
		$data = new stdClass();
		$data->submission = Submission::find($id);
		$data->revisions = Submission::where('quest_id', '=', $data->submission->quest_id)
									->where('user_id', '=', $data->submission->user_id)
									->get();
		$data->quest = Quest::find($data->submission->quest_id);
		$data->comments = Comment::where('quest_id', '=', $data->submission->quest_id)
									->where('user_id', '=', $data->submission->user_id)
									->get();
		
		return View::make('submission.view')
		->with('data',$data);
	
	}

	public function get_revise($id) {
		$data = new stdClass();
		$data->submission = Submission::find($id);
		$data->revisions = Submission::where('quest_id', '=', $data->submission->quest_id)
									->where('user_id', '=', $data->submission->user_id)
									->get();		
		$data->quest = Quest::find($data->submission->quest_id);
		$data->comments = Comment::where('quest_id', '=', $data->submission->quest_id)
									->where('user_id', '=', $data->submission->user_id)
									->get();
		return View::make('submission.revise')
		->with('data',$data);

	
	}


	public function get_grade($id) {
		//get the submission
		$submission = Submission::find($id);
		//get the quest information
		if ($submission) {
			$quest = Quest::find($submission	
							->quest_id);
		}
		else {
			return Redirect::to('admin/submissions')
				->with_message('That submission no longer exists!', 'error');

		}
		
		$student = User::find($submission->user_id)->username;
			$revisions = Submission::where('quest_id', '=', $submission->quest_id)
									->where('user_id', '=', $submission->user_id)
									->get();
			$latest_revision_number = Submission::where('quest_id', '=', $submission->quest_id)
									->where('user_id', '=', $submission->user_id)
									->max('revision');
									
		if($submission->revision == $latest_revision_number) {
			$latest_revision = true;
		}
		else {
			$latest_revision = false;
		}
		$comments = Comment::where('quest_id', '=', $submission->quest_id)
							->where('user_id', '=', $submission->user_id)
							->get();
		//get the skills for the quest
		$skills = DB::table('quest_skill')
						->where('quest_id', '=', $quest->id)
						->order_by('skill_id')
						->lists('skill_id');
		//deduplicate the skills
		$skills = array_unique($skills);
		
							
		
		
		$skill_history = array();
		//get the info for each skill
		foreach($skills as $skill) {

			$history = DB::table('skill_user_history')->where('quest_id', '=', $quest->id)
											->where('user_id', '=', $submission->user_id)
											->where('skill_id', '=', $skill)
											->get();
			foreach($history as $h) {
				$date = new DateTime($h->created_at);
				$skill_history[$h->submission_id]["info"] = $date->format('F j, Y');
				$skill_history[$h->submission_id]["skill"][$h->skill_id] = array('name' => Skill::where('id', '=', $skill)->first()->name, 'amount' => $h->amount);
			}


			$rewardOptions = new stdClass();
			$rewardOptions->name = Skill::where('id', '=', $skill)
											->first()
											->name;
			$rewardOptions->id = $skill;
			$rewardOptions->rewards = array();
			$questSkills = DB::table('quest_skill')
							->where('quest_id', '=', $quest->id)
							->where('skill_id', '=', $skill)
							->get();
		//add each reward value for the skill
			foreach ($questSkills as $reward) {
				$rewardOptions->rewards[$reward->label] = $reward->amount;
				if ($submission->graded == 0) {
					$rewardOptions->rewards['current'] = $reward->amount;
				}
				else {
					$user_quest_skills = DB::table('skill_user')
										->where('quest_id', '=', $quest->id)
										->where('user_id', '=', $submission->user_id)
										->where('skill_id', '=', $skill)
										->first()->amount;
					$rewardOptions->rewards['current'] = $user_quest_skills;
				}
			}
			$rewards[] = $rewardOptions;
		}
		

		
		return View::make('submission.grade')
		->with('data', 
				array('quest' => $quest,
				 	  'submission' => $submission,
				 	  'revisions' => $revisions,
				 	  'rewards' => $rewards,
				 	  'comments' => $comments,
				 	  'student' => $student,
				 	  'latest' => $latest_revision,
				 	  'history' => $skill_history)
				 	  );
	
	}

	
	public function post_grade() {
		//save comment
		$comment_submission_field = "";

		if (Input::get('quest_type') == 2) {
			$comment_submission_field = "submission_id";
			$submission = Submission::find(Input::get('submission_id'));
			$submission->graded = TRUE;
			if ($submission->revision > 0) {
				$revision = TRUE;
			}
			$submission->save();
			$quest = Quest::find($submission->quest_id);
			
			$comment = Comment::create(
							array($comment_submission_field => Input::get('submission_id'),
								  'comment' => Input::get('notes'),
								  'user_id' => $submission->user_id,
								  'commenter_id' => Session::get('uid'),
								  'quest_id' => Input::get('quest_id'),
								  ));	
		}
		else {
			$quest = Quest::find(Input::get('quest_id'));
		}

			if (Input::has('notify_student')) {
				$notice = new Notice;
				$notice->notification = Input::get('notes');
				$notice->title = $quest->name . " has been graded";
				$notice->user_id = $submission->user_id;
				$notice->group_id = Session::get('current_course');			
				$notice->url = "submission/revise/".$submission->id;
				$notice->save();
				$message = "<p>".Input::get('notes')."</p><p>For more information, visit <a href='".URL::to($notice->url)."'>the class website</a></p>";
				Info::notify($submission->user_id, $notice->title, $message);
			}

			DB::table('skill_user')
					->where('user_id', '=', Input::get('user_id'))
					->where('quest_id', '=', Input::get('quest_id'))
					->delete();					

		//Save user's newly acquired skills

		foreach(Input::get('rewards') as $skill => $reward) {
			
				
			DB::table('skill_user')->insert(
										array('user_id' => Input::get('user_id'),
											  'quest_id' => Input::get('quest_id'),
											  'group_id' => Session::get('current_course'),
											  'skill_id' => $skill,
											  'amount' => $reward,
											  'created_at' => DB::raw('NOW()'),
											  'updated_at' => DB::raw('NOW()')
											)
										);

			DB::table('skill_user_history')->insert(							
											array('user_id' => Input::get('user_id'),
												  'quest_id' => Input::get('quest_id'),
												  'submission_id' => $submission->id,
												  'group_id' => Session::get('current_course'),
												  'skill_id' => $skill,
												  'amount' => $reward,
												  'created_at' => DB::raw('NOW()'),
												  'updated_at' => DB::raw('NOW()')
												)
											);


		}
		//TODO: go somewhere else
		return Redirect::to('/admin/submissions');

	}

	public function get_new_submissions() {
		$data = new stdClass();
		$data->title = "Ungraded Submissions";

		$submissions = Group::find(Session::get('current_course'))
					->submissions()
					->where('graded', '=', 0)
					->where('revision', '=', 0)
					->order_by('created_at')
					->get();
		foreach ($submissions as $submission) {
			$newer_submissions = Submission::where('quest_id', '=', $submission->quest_id)
						->where('user_id', '=', $submission->user_id)
						->where('revision', '>', 0)
						->where('graded', '=', 1)
						->count();
			if ($newer_submissions == 0) {
						
				$data->submissions[] = array('id' => $submission->id,
                                             'revision' => $submission->revision,
										 'quest' => DB::table('quests')
													->where('id', '=', $submission->quest_id)
													->first()
													->name,
										 'created' => $submission->created_at,
										 'type' => 'text',
										 'username' => User::find($submission->user_id)->username);
				}
		}
        
		$revisions = Group::find(Session::get('current_course'))
					->submissions()
					->where('graded', '=', 0)
					->where('revision', '>', 0)
					->order_by('created_at')
					->get();

		if($revisions) {
			foreach ($revisions as $revision) {
				$data->revisions[] = array('id' => $revision->id,                               
                                             'revision' => $revision->revision,
											 'quest' => DB::table('quests')
														->where('id', '=', $revision->quest_id)
														->first()
														->name,
											 'created' => $revision->created_at,
											 'type' => 'text',
											 'username' => User::find($revision->user_id)->username);
			}
        }
        else {
            $data->revisions = NULL;
        }
		return View::make('submission.index')
				->with('data', $data);
	}
	
	
}

?>