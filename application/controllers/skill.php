<?php

class Skill_Controller extends Base_Controller {
	public $restful = TRUE;
	
	public function get_index() {
		$skills = Skill::where('group_id', '=', Session::get('current_course'))->order_by('name', 'asc');
		if ($skills->count() == 0) {
			//no skills setup yet
			return View::make('skills.new');
		}
		else {
			//got skills
			return View::make('skills.index')
					->with('skills', $skills->get());
		}
	}
	
	public function post_index() {
		$skill = Skill::create(
			array('name' => Input::get('skill'),
				  'group_id' => Session::get('current_course')
				  ));

		$skills = Skill::where('group_id', '=', Session::get('current_course'));
			return View::make('skills.index')
					->with('skills', $skills->order_by('name', 'asc')->get());
				
	
	}

	public function get_remove($id) {
		
		$skill = Skill::find($id);

		if ($skill->group_id == Session::get('current_course')) {
			$skill->delete();
			DB::table('quest_skill')
				->where('skill_id', '=', $id)
				->delete();
			DB::table('skill_user')
				->where('skill_id', '=', $id)
				->delete();
		}
		return Redirect::to('admin/skills');

	}

	public function post_edit() {
		
		$skill = Skill::find(Input::get('skill_id'));

		if ($skill->group_id == Session::get('current_course')) {
			$skill->name = Input::get('skill');
			$skill->save();
		}
		return Redirect::to('admin/skills');

	}


}