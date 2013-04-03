<?php

class Meta extends Eloquent
{
	public static $table = 'users_metadata';
	public function user() {
		return $this->has_one('User');
	}
}
