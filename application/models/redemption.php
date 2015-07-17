<?php
class Redemption extends Eloquent
{
	public function quest() {
		return $this->has_one('Quest');
	}
	
}

