<?php

class Skill extends Eloquent
{
	public function users() {
		return $this->has_many('User');
	}

	public function group() {
		return $this->has_one('Group');
	}
	
	public function quests()
    {
 		return $this->has_many('Quest');
     }
	
}