<?php
class Level extends Eloquent
{
	public function groups() {
		return $this->has_one('Group');
	}
	
}

