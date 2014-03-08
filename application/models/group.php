<?php
class Group extends Eloquent
{
	public function users() {
		return $this->has_many_and_belongs_to('User', 'users_groups');
	}

	public function notices() {
		return $this->has_many('Group');
	}
	
	public function quests() {
		return $this->has_many('Quest');
	}
	
	public function posts() {
		return $this->has_many('Post');
	}
	
	public function teams() {
		return $this->has_many('Team');
	}
	
	public function levels() {
		return $this->has_many('Level');
	}

	public function variables() {
		return $this->has_many('Variable');
	}
	
	public function skills() {
		return $this->has_many('Skill');
	}
	
	public function submissions() {
		return $this->has_many('Submission');
	}
	
	public function uploads() {
		return $this->has_many('Upload');
	}

	public function questions() {
		return $this->has_many('Question');
	}
}

