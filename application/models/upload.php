<?php

class Upload extends Eloquent
{
	public function quest() {
		return $this->has_one('Quest');
	}

	public function user() {
		return $this->has_one('User');
	}
	
	public function group() {
		return $this->has_one('Group');
	}
}