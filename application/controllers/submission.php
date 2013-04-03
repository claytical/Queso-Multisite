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
	
	public function get_view_text($id) {
		$data = new stdClass();
		$data->submission = Submission::find($id);
		$data->quest = Quest::find($data->submission->quest_id);
		
		return View::make('submission.view')
		->with('data',$data);
	
	}


	public function get_view_file($id) {
		$data = new stdClass();
		$data->submission = Upload::find($id);
		$data->quest = Quest::find($data->submission->quest_id);
		$data->comments = Comment::where('quest_id', '=', $data->submission->quest_id)
									->where('user_id', '=', $data->submission->user_id)
									->get();
		
		return View::make('submission.view')
		->with('data',$data);
	
	}
	
	public function get_revise_text($id) {
		$data = new stdClass();
		$data->submission = Submission::find($id);
		$data->quest = Quest::find($data->submission->quest_id);
		$data->comments = Comment::where('quest_id', '=', $data->submission->quest_id)
									->where('user_id', '=', $data->submission->user_id)
									->get();
		return View::make('submission.revise')
		->with('data',$data);

	
	}
	
	public function get_revise_file($id) {
		$data = new stdClass();
		$data->submission = Upload::find($id);
		$data->quest = Quest::find($data->submission->quest_id);
		
		return View::make('submission.revise')
		->with('data',$data);
	
	}
	public function get_grade_text($id) {
		//get the submission
		$submission = Submission::find($id);
		//get the quest information
		$quest = Quest::find($submission	
							->quest_id);
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

		//get the info for each skill
		foreach($skills as $skill) {
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
				$rewardOptions->rewards[$reward->amount] = $reward->label;

			}
			$rewards[] = $rewardOptions;
		}
		
		
		return View::make('submission.grade')
		->with('data', 
				array('quest' => $quest,
				 	  'submission' => $submission,
				 	  'rewards' => $rewards,
				 	  'comments' => $comments)
				 	  );
	
	}
	

	public function get_grade_file($id) {

		//get the submission
		$submission = Upload::find($id);
		//get the quest information
		$quest = Quest::find($submission
							->quest_id);
		//get comments
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

		//get the info for each skill
		foreach($skills as $skill) {
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
				$rewardOptions->rewards[$reward->amount] = $reward->label;

			}
			$rewards[] = $rewardOptions;
		}
		
		
		return View::make('submission.grade')
		->with('data', 
				array('quest' => $quest,
				 	  'submission' => $submission,
				 	  'rewards' => $rewards,
				 	  'comments' => $comments)
				 	  );
	
	}


		public function post_grade() {
			$notice = new Notice;

			$notice->notification = Input::get('notes');
		
		//save comment
		$comment_submission_field = "";

		if (Input::get('quest_type') == 3) {
			$comment_submission_field = "upload_id";
			$file = Upload::find(Input::get('submission_id'));
			$file->graded = TRUE;
			if ($file->revision > 0) {
				$revision = TRUE;
			}
			$file->save();
			$quest = Quest::find($file->quest_id);
			$notice->title = $quest->name . " has been graded";
			$notice->user_id = $file->user_id;
			$notice->group_id = Session::get('current_course');			
			$notice->url = "submission/upload/".$file->id;
			$comment = Comment::create(
							array($comment_submission_field => Input::get('submission_id'),
								  'comment' => Input::get('notes'),
								  'user_id' => $file->user_id,
								  'commenter_id' => Session::get('uid'),
								  'quest_id' => Input::get('quest_id'),
								  ));	

		}
		else if (Input::get('quest_type') == 2) {
			$comment_submission_field = "submission_id";
			$submission = Submission::find(Input::get('submission_id'));
			$submission->graded = TRUE;
			if ($submission->revision > 0) {
				$revision = TRUE;
			}
			$submission->save();
			$quest = Quest::find($submission->quest_id);
			$notice->title = $quest->name . " has been graded";
			$notice->user_id = $submission->user_id;
			$notice->group_id = Session::get('current_course');			
			$notice->url = "submission/revise/".$submission->id;

			$comment = Comment::create(
							array($comment_submission_field => Input::get('submission_id'),
								  'comment' => Input::get('notes'),
								  'user_id' => $submission->user_id,
								  'commenter_id' => Session::get('uid'),
								  'quest_id' => Input::get('quest_id'),
								  ));	
		}

			$notice->save();

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
		}
		//TODO: go somewhere else
		return Redirect::to('/admin/submissions');

	}

	public function get_new_submissions() {
		$data = new stdClass();
		$data->title = "New Submissions";

		$submissions = Group::find(Session::get('current_course'))
					->submissions()
					->where('graded', '=', 0)
					->where('revision', '=', 0)
					->order_by('created_at')
					->get();
		$uploads = Group::find(Session::get('current_course'))
					->uploads()
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
										 'quest' => DB::table('quests')
													->where('id', '=', $submission->quest_id)
													->first()
													->name,
										 'created' => $submission->created_at,
										 'type' => 'text',
										 'username' => User::find($submission->user_id)->username);
				}
		}
		
		foreach ($uploads as $upload) {
			$newer_uploads = Upload::where('quest_id', '=', $submission->quest_id)
						->where('user_id', '=', $submission->user_id)
						->where('revision', '>', 0)
						->where('graded', '=', 1)
						->count();
			if ($newer_uploads == 0) {

				$data->submissions[] = array('id' => $upload->id,
										 'quest' => DB::table('quests')
													->where('id', '=', $upload->quest_id)
													->first()
													->name,
										 'created' => $upload->created_at,
										 'type' => 'file',
										 'username' => User::find($upload->user_id)->username);
			}
		}
		return View::make('submission.index')
				->with('data', $data);
	}
	
	
	public function get_latest_revisions() {
		$data = new stdClass();
		$data->title = "Latest Revisions";
		$submissions = Group::find(Session::get('current_course'))
					->submissions()
					->where('graded', '=', 0)
					->where('revision', '>', 0)
					->order_by('created_at')
					->get();
		$uploads = Group::find(Session::get('current_course'))
					->uploads()
					->where('graded', '=', 0)
					->where('revision', '>', 0)
					->order_by('created_at')
					->get();
		if($submissions || $uploads) {
			foreach ($submissions as $submission) {
				$data->submissions[] = array('id' => $submission->id,
											 'quest' => DB::table('quests')
														->where('id', '=', $submission->quest_id)
														->first()
														->name,
											 'created' => $submission->created_at,
											 'type' => 'text',
											 'username' => User::find($submission->user_id)->username);
			}
			
			foreach ($uploads as $upload) {
				$data->submissions[] = array('id' => $upload->id,
											 'quest' => DB::table('quests')
														->where('id', '=', $upload->quest_id)
														->first()
														->name,
											 'created' => $upload->created_at,
											 'type' => 'file',
											 'username' => User::find($upload->user_id)->username);
			}
		}
		else {
			$data->submissions = NULL;		
		}
		return View::make('submission.index')
				->with('data', $data);
	}

	
}

?>