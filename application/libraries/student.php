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
		if ($ids) {
			return Group::find($group_id)
								->quests()
								->where_not_in('id',$ids)
								->count();			
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
}