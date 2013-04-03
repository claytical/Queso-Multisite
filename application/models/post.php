<?php

class Post extends Eloquent
{
	public function user() {
		return $this->has_one('User');
	}
	public function group() {
		return $this->has_one('Group');
	}
}