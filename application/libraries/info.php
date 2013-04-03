<?php

class Merge {


	public static function max_skill_points($quest) {
			foreach(array_unique($quest->skills()->lists('id')) as $skill) {
				$n = DB::table('quest_skill')
						->where('quest_id', '=', $quest->id)
						->where('skill_id', '=', $skill)
						->join('skills', 'skills.id', '=', 'quest_skill.skill_id')
						->order_by('amount', 'desc')
						->first();
				$skills[] = $n;
				$quest->max_skills = $skills;

			}
			return $quest;
		}

}