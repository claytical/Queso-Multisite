<?php


class Question_Controller extends Base_Controller {

	// Since we will use get and post, we need to make controller to be RESTful.
	public $restful = true;

	// Attach an Auth filter to every route in this controller to make sure the user is logged in
	public function __construct(){
		//$this->filter('before', 'auth');
	}
	

	public function get_index() {
		$questions = Group::find(Session::get('current_course'))
		->questions()
		->join('users', 'users.id', '=', 'questions.user_id')
		->get(array('question', 'questions.user_id', 'questions.id', 'users.username'));
		if ($questions) {
			//need a separate index page for non-logged in people
			return View::make('questions.index')
			->with('questions', $questions);
		}
		else {
			return View::make('questions.index');
		
		}
	
	}
	public function get_details($id) {
		$question = Question::find($id);
		$question->answers = $question
								->answers()
								->join('users', 'users.id', '=', 'answers.user_id')
								->order_by('thanks', 'desc')
								->get(array('answers.id', 'answers.thanks', 'answers.answer', 'answers.user_id', 'users.username'));
		
		return View::make('questions.details')
					->with('question', $question);
	}

	public function post_answer($id) {
		$answer = Answer::create(
					array('answer' => Input::get('answer'),
						  'question_id' => $id,
						  'user_id' => Session::get('uid')));

		return Redirect::to('question/'.$id);

	}
	public function get_thanks($id) {
		$answer = Answer::find($id);
		$answer->thanks++;
		$answer->save();
		return Redirect::to('question/'.$answer->question_id);
	}
	public function get_ask() {
		$info = new stdClass();
		$quests = Quest::where('group_id', '=', Session::get('current_course'))
						->order_by('name', 'asc')
						->lists('id', 'name');
		return View::make('questions.ask')
					->with('quests', $quests);
	}

	public function post_ask() {
			$question = Question::create(
				array('question' => Input::get('question'),
					  'user_id' => Session::get('uid'),
					  'quest_id' => Input::get('quest_id'),
					  'group_id' => Session::get('current_course')
					  ));	

		return Redirect::to('question/'.$question->id);
		}


	/* 
		list of all posts for the administration menu
	
	*/
	public function get_admin() {
		return View::make('questions.admin')
		->with('questions', Group::find(Session::get('current_course'))
		->questions()
		->get());
	
	}
	
	
	
}

?>