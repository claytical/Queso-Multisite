
<?php

class Quest extends Eloquent
{
	public function users() {
		return $this->has_many_and_belongs_to('User');
	}

	public function uploads() {
		return $this->has_many('Upload');
	}
	
	public function submissions() {
		return $this->has_many('Submission');
	}

	public function skills()
    {
 		return $this->has_many_and_belongs_to('Skill');
     }
    
    public function groups() {
    	return $this->has_one('Group');
    }

}