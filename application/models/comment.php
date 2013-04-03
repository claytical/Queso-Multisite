<?php

class Comment extends Eloquent
{
	public function user() {
		return $this->has_one('User');
	}

	public function quest() {
		return $this->has_one('Quest');
	}

	public function submission() {
		return $this->has_one('Submission');
	}

}