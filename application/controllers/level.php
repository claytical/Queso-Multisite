<?php

class Level_Controller extends Base_Controller {
	public $restful = TRUE;
	
	public function get_index() {
		$levels = Level::where('group_id', '=', Session::get('current_course'))->order_by('amount', 'asc');
		if ($levels->count() == 0) {
			//no skills setup yet
			return View::make('levels.new');
		}
		else {
			//got skills
			return View::make('levels.index')
					->with('levels', $levels->get());
		}
	}
	
	public function post_index() {
		$level = Level::create(
			array('label' => Input::get('label'),
				  'amount' => Input::get('amount'),
				  'group_id' => Session::get('current_course')
				  ));

		$levels = Level::where('group_id', '=', Session::get('current_course'));
			return View::make('levels.index')
					->with('levels', $levels->order_by('amount', 'asc')->get());
				
	
	}

}