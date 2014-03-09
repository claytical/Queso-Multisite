<?php

class User extends Eloquent
{
	public function meta() {
		return $this->has_one('Meta', 'users_metadata');
	}
	public function comments() {
		return $this->has_many('Comment');
	}

	public function posts() {
		return $this->has_many('posts');
	}
	
	public function uploads() {
		return $this->has_many('Upload');
	}
	
	public function teams() {
		return $this->has_many_and_belongs_to('Team', 'users_teams');
	}
	
	public function submissions() {
		return $this->has_many('Submission');
	}

	public function quests()
    {
 		return $this->has_many_and_belongs_to('Quest');
     }
	
	public function notices() {
		return $this->has_many('Notice');
	}
	public function skills() {
		return $this->has_many_and_belongs_to('Skill');
	}

	public function groups() {
		
		return $this->has_many_and_belongs_to('Group', 'users_groups');
	}

	public function answers() {
		return $this->has_many('Answer');
	}

	public function questions() {
		return $this->has_many('Question');
	}
}
