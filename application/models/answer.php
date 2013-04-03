<?php

class Answer extends Eloquent
{
	public function user() {
		return $this->has_one('User');
	}
	
	public function question() {
		return $this->has_one('Answer');
	}

}