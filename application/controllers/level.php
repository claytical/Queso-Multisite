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
        if (Input::has('tab')) {

            return Redirect::to('admin/course#levels')
					->with_message($level->label . " created.", 'success');        }
        else {
            return View::make('levels.index')
					->with('levels', $levels->order_by('amount', 'asc')->get());

        }
	
	}
	public function post_edit() {
		
		$level = Level::find(Input::get('level_id'));

		if ($level->group_id == Session::get('current_course')) {
			$level->label = Input::get('label');
			$level->amount = Input::get('amount');
            $level->save();
		}
        if (Input::has('tab')) {

            return Redirect::to('admin/course#levels')
					->with_message($level->label . " modified.", 'success');        }
        else {

            return Redirect::to('admin/levels');
        }
	}
	public function get_delete($id) {
		$level = Level::find($id);
		if ($level->group_id == Session::get('current_course')) {
			$label = $level->label;
			$level->delete();			
			return Redirect::to('admin/course/#levels')
					->with_message($label . " deleted.", 'success');

		}
		else {
			return Redirect::to('admin/course#levels')
					->with_message("Access denied", 'error');

		}
		
	}

}