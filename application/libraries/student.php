<?php

class Student {


	
	public static function lowest_skill_amount($user_id, $group_id) {
		$group_skills = Group::find($group_id)->skills()->get();
		$lowest_amount = 9999999999999999;
		foreach($group_skills as $skill) {
			$amount = DB::table('skill_user')
						->where('user_id', '=', $user_id)
						->where('skill_id', '=', $skill->id)
						->sum('amount');
			
			if ($amount == NULL) {
				$amount = 0;
			}		
			if ($amount < $lowest_amount) {
				$lowest_amount = $amount;	
			}
		}
		return $lowest_amount;
	
	}
	
	public static function skill_levels($user_id, $group_id) {
		
		$group_skills = Group::find($group_id)->skills()->get();
		foreach($group_skills as $skill) {
			$amount = DB::table('skill_user')
						->where('user_id', '=', $user_id)
						->where('skill_id', '=', $skill->id)
						->sum('amount');
			
			$skills[] = array('name' => $skill->name,
								  'amount' => $amount
									);

		}
		if (empty($skills)) {
			return NULL;
		}
		return $skills;			
	}
	public static function skill_levels_check($user_id, $group_id) {
		
		$group_skills = Group::find($group_id)->skills()->get();
		foreach($group_skills as $skill) {
			$amount = DB::table('skill_user')
						->where('user_id', '=', $user_id)
						->where('skill_id', '=', $skill->id)
						->sum('amount');
			if ($amount) {
				$skills[$skill->id] = $amount;
			}
			else {
				$skills[$skill->id] = 0;
			}
		}
		if (empty($skills)) {
			return NULL;
		}
	
		return $skills;			
	}
		
	
	
	public static function current_level($user_id, $group_id) {

		$lowest_skill_amount = Student::lowest_skill_amount($user_id, $group_id);
		$current_level = Group::find($group_id)
		->levels()
		->where('amount', '<=', $lowest_skill_amount)
		->order_by('amount', 'desc');
		if ($current_level) {
			return $current_level->first();
		}
		else {
			return 0;
		}

	}
	
	public static function next_level($user_id, $group_id) {
		$next_level_amount = Group::find($group_id)
		->levels()
		->where('amount', '>', Student::lowest_skill_amount($user_id, $group_id))
		->order_by('amount', 'asc');

		if ($next_level_amount->first()) {
			return $next_level_amount->first()->amount;
		}
		else {
			return 0;		
		}		
	
	}

	public static function is_instructor($user_id) {

		//in the course, are they an instructor?
			if(DB::table('users_groups')
				->where('user_id', '=', $user_id)
				->where('group_id', '=', Session::get('current_course'))
				->where('instructor', '=', 1)
				->count() == 1) {
				return TRUE;
			}
			else {
				return FALSE;
			}

	}

	public static function is_in_course() {

		//in the course, are they an instructor?
			if(DB::table('users_groups')
				->where('user_id', '=', Session::get('uid'))
				->where('group_id', '=', Session::get('current_course'))
				->count() == 1) {
				return TRUE;
			}
			else {
				return FALSE;
			}

	}
	public static function completed_quest_list($user_id, $group_id) {
		return	User::find($user_id)->quests()
						->where('group_id', '=', $group_id)
						->lists('id');							
	}
	
	public static function available_quests($user_id, $group_id) {
		$ids = Student::completed_quest_list($user_id, $group_id);
		$questCount = 0;
		if ($ids) {
			$quests = Group::find($group_id)
							->quests()
							->where_not_in('id',$ids);


		$student_skill_levels = Student::skill_levels_check($user_id, $group_id);

		$questsWithPoints = array();
        if ($quests->get()) {
		
			foreach($quests->get() as $quest) {
				$level_required = DB::table('quest_lock')->where('quest_id', '=', $quest->id)->get();
				//open lock
				$allowed = true;					
				//loop through and check requirements
				foreach($level_required as $lock) {
					//student amount is less than the threshold for the skill
					if(array_key_exists($lock->skill_id, $student_skill_levels)) {

						if ($student_skill_levels[$lock->skill_id] < $lock->requirement) {
							//close lock
							$allowed = false;
						}
					}
				}
				//still open, add it to the list
				if ($allowed) {
					$questCount++;
				}
				
			}
		}

		return $questCount;
		}
		else {
			return Group::find($group_id)
								->quests()
								->count();
		}
	
	}
	
	public static function pending_quests($user_id, $group_id) {
		$ids = Student::completed_quest_list($user_id, $group_id);
		$quests = User::find($user_id)
							->quests()
							->where('group_id', '=', $group_id);

		if ($ids) {
			$graded_quests = DB::table('skill_user')
								->where('group_id', '=', $group_id)
								->where('user_id', '=', $user_id)
								->lists('quest_id');
			if (!empty($graded_quests)) {
				return $quests->where_not_in('quest_id', $graded_quests)
								->count();
			}
			else {
				return 0;
			}
		}
		else {
			return 0;
		}
	
	}
	
	
	public static function projected_level($user_id, $group_id) {
		//Get Completed Quests
		$playerQuests = User::find($user_id)->quests();
		$ids = $playerQuests->lists('id');
		$projection = array();
		if (!empty($ids)) {
			//find quests that haven't been completed
			$quests = Group::find(Session::get('current_course'))
				->quests()
				->where_not_in('id',$ids)
				->where('visible', '=', 1)
				->where(function ($query) {
					$query->where('expires', '>', new DateTime('today'))
							->or_where('expires', 'IS', DB::raw('null'));
							})
				->get();
			//get all course skills
			$skills = Skill::where('group_id', '=', $group_id)->get();
		//find remaining amounts of potential skill points
			foreach($skills as $skill) {
				$skills_to_gain = DB::table('quest_skill')
					->where('skill_id', '=', $skill->id)
					->where('label', '=', 'Maximum')
					->where_not_in('quest_id', $ids)
					->sum('amount');

				$current_amount = DB::table('skill_user')
							->where('user_id', '=', $user_id)
							->where('skill_id', '=', $skill->id)
							->sum('amount');

				$projection['skills'][] = array(
							'id' => $skill->id,
							'label' => $skill->name,
							'left' => $skills_to_gain,
							'current' => $current_amount,
							'projected' => $current_amount + $skills_to_gain,);

			}
			$lowest_projected_skill_amount = 9999999999999999;
			foreach ($projection['skills'] as $projected_skill) {
				if ($projected_skill['projected'] == NULL) {
					$projected_skill['projected'] = 0;
				}
				
				if ($projected_skill['projected'] < $lowest_projected_skill_amount) {
					$lowest_projected_skill_amount = $projected_skill['projected'];
				}

			}
			$best_level = Group::find($group_id)
			->levels()
			->where('amount', '<=', $lowest_projected_skill_amount)
			->order_by('amount', 'desc');
			if ($best_level) {
				$projection['level'] =  $best_level->first()->label;
			}
			else {
				$projection['level'] = 0;
			}
			
			return $projection;
		}
	return NULL;
}
}