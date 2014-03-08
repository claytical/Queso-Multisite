<?php
class Team extends Eloquent
{
	public function users() {
		return $this->has_many_and_belongs_to('User', 'users_teams');
	}

	public function group() {
		return $this->has_one('Group');
	}
	
}

