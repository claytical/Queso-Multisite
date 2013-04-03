<?php
class Variable extends Eloquent
{
	public function group() {
		return $this->has_one('Group');
	}

}

