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
		if (Input::has('tab')) {
            return Redirect::to('admin/course#skills')
					->with_message($skill->name . " created.", 'success');
        
        }
        else {
            return View::make('skills.index')
					->with('skills', $skills->order_by('name', 'asc')->get());
        }	
	
	}
	
		public function get_remove_confirm($id) {
		
		$skill = Skill::find($id);
        $skillName = $skill->name;
		
		if ($skill->group_id == Session::get('current_course')) {
			$skill->delete();
			DB::table('quest_skill')
				->where('skill_id', '=', $id)
				->delete();
			DB::table('skill_user')
				->where('skill_id', '=', $id)
				->delete();
			DB::table('quest_lock')
				->where('skill_id', '=', $id)
				->delete();
		}
		return Redirect::to('admin/course#skills')
            ->with_message($skillName . " deleted.", 'success');  
	}


	public function get_remove($id) {
		
		$skill = Skill::find($id);
        $skillName = $skill->name;


		if	(DB::table('quest_skill')->where('skill_id', '=', $id)->count() > 0) {
			return Redirect::to('admin/course#skills')
				->with_message($skillName . " has quests attached to it. In order to delete it, you need to remove all quests that are associated with it.", 'warning');  
		
		}

		if	(DB::table('skill_user')->where('skill_id', '=', $id)->count() > 0) {
			return Redirect::to('admin/course#skills')
				->with_message("<p>Students have already earned " . $skillName . ". If you remove it, they will lose those points.</p><p><a class='btn btn-danger btn-md' href='".URL::to("admin/skill/remove/".$id."/confirm")."'>Remove Anyway</a></p>", 'warning');  
		
		}

		
		if ($skill->group_id == Session::get('current_course')) {
			$skill->delete();
			DB::table('quest_skill')
				->where('skill_id', '=', $id)
				->delete();
			DB::table('skill_user')
				->where('skill_id', '=', $id)
				->delete();
			DB::table('quest_lock')
				->where('skill_id', '=', $id)
				->delete();
		}
		return Redirect::to('admin/course#skills')
            ->with_message($skillName . " deleted.", 'success');  
	}

	public function post_edit() {
		
		$skill = Skill::find(Input::get('skill_id'));

		if ($skill->group_id == Session::get('current_course')) {
			$skill->name = Input::get('skill');
			$skill->save();
		}
		if (Input::has('tab')) {
            return Redirect::to('admin/course#skills')
					->with_message($skill->name . " created.", 'success');
        
        }
        else {
            return Redirect::to('admin/skills');
        }
	}


}