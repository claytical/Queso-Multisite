<?php

class Course {


	public static function skill_list($group_id) {
		$group_skills = Group::find($group_id)->skills()->get();
		foreach($group_skills as $skill) {
			$skills[] = array('name' => $skill->name,
							  'amount' => $skill->amount,
								);
		}
		return $skills;	
	}
	
	public static function lookup($code) {
		return Group::where('code', '=', $code)->first();
	}

	public static function code() {
		return Group::where_id(Session::get('current_course'))->first()->code;
	}

	public static function generate_code() {
	    $chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	    srand((double)microtime()*1000000);
	    $i = 0;
	    $pass = '';
	    while ($i <= 12) {
	        $num = rand() % 33;
	        $tmp = substr($chars, $num, 1);
	        $pass = $pass . $tmp;
	        $i++;
	    }
	    return $pass;		
	}

	public static function is_instructor() {
		$user = Sentry::user(Session::get(Config::get('sentry::sentry.session.user')));
		if ($user->in_group(Session::get('current_course'))) {
		//in the course, are they an instructor?
			if(DB::table('users_groups')
				->where('user_id', '=', $user->id)
				->where('group_id', '=', Session::get('current_course'))
				->where('instructor', '=', 1)
				->count() == 1) {
				return TRUE;
			}
		return FALSE;
		}
	}

	public static function posts_name() {
		$course = Group::find(Session::get('current_course'));
		$dropdown = $course->variables()->where('label', '=', 'dropdown')->first();
		return $dropdown->variable;
	}

	public static function has_posts() {
		if(Group::find(Session::get('current_course'))->posts()->count() > 0) {
			return TRUE;
		}
	}
	
	public static function has_post_menu() {
		if(Group::find(Session::get('current_course'))->posts()->where('menu', '=', '1')->count() > 0) {
			return TRUE;
		}
	}
	public static function has_quests() {
		if(Group::find(Session::get('current_course'))->quests()->count() > 0) {
			return TRUE;
		}
	}

}