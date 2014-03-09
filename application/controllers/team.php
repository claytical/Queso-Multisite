<?php

class Team_Controller extends Base_Controller {
	public $restful = TRUE;
	
	public function get_index() {
		$teams = Team::where('group_id', '=', Session::get('current_course'))->order_by('label', 'asc');
		if ($teams->count() == 0) {
			//no skills setup yet
			return View::make('teams.new');
		}
		else {
			//got skills
			return View::make('teams.index')
					->with('teams', $teams->get());
		}
	}
	
	public function post_index() {
		$team = Team::create(
			array('label' => Input::get('label'),
				  'group_id' => Session::get('current_course')
				  ));

		$team = Team::where('group_id', '=', Session::get('current_course'));
        if (Input::has('tab')) {

            return Redirect::to('admin/course#teams')
					->with_message(Input::get('label') . " created.", 'success');        }
        else {
            return View::make('teams.index')
					->with('teams', $teams->order_by('label', 'asc')->get());

        }
	
	}
	public function post_edit() {
		
		$team = Team::find(Input::get('team_id'));

		if ($team->group_id == Session::get('current_course')) {
			$team->label = Input::get('label');
            $team->save();
		}
        if (Input::has('tab')) {

            return Redirect::to('admin/course#teams')
					->with_message($team->label . " modified.", 'success');        }
        else {

            return Redirect::to('admin/teams');
        }
	}
	
	public function get_delete($id) {
		$team = Team::find($id);
		if ($team->group_id == Session::get('current_course')) {
			$label = $team->label;
			$team->delete();			
			return Redirect::to('admin/course/#teams')
					->with_message($label . " deleted.", 'success');

		}
		else {
			return Redirect::to('admin/course#teams')
					->with_message("Access denied", 'error');

		}
		
	}

}