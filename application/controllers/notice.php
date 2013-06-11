<?php


class Notice_Controller extends Base_Controller {

	// Since we will use get and post, we need to make controller to be RESTful.
	public $restful = true;

	// Attach an Auth filter to every route in this controller to make sure the user is logged in
	public function __construct(){
		//$this->filter('before', 'auth');
	}
	
	/*
	* list of comments to a user in a group
	*/ 


	public function get_index() {
		$notices = User::find(Session::get('uid'))
						->notices()
						->where('group_id', '=', Session::get('current_course'))
						->where('hidden', '!=', 1)
						->get();

			//need a separate index page for non-logged in people
			return View::make('notices.index')
			->with('notices', $notices);
	
	}

	public function get_hide($id) {
		$notice = Notice::find($id);
		if ($notice->user_id == Session::get('uid') && $notice->group_id == Session::get('current_course')) {
			$notice->hidden = TRUE;
			$notice->save();
		}
		
		return Redirect::to('notices');
		
	}

	public function get_hide_all() {
		$notices = Notice::where('user_id', '=', Session::get('uid'))->get();
		foreach($notices as $notice) {
			$notice->hidden = TRUE;
			$notice->save();
		}
		return Redirect::to('notices');
	}
	
	
}

?>