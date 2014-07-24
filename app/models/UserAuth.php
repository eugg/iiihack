<?php

class UserAuth extends Eloquent {

    protected $table = 'user_auth';
	/**
	 * Get the relation owner
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}

}
