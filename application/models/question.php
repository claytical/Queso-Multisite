<?php

class Question extends Eloquent
{
	public function user() {
		return $this->has_one('User');
	}

	public function quest() {
		return $this->has_one('Quest');
	}

	public function group() {
		return $this->has_one('Group');
	}
	
	public function answers() {
		return $this->has_many('Answer');
	}

}