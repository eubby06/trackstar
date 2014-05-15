<?php namespace App\Models;

class User extends Base
{
	protected $table = 'users';

	public function profile()
	{
		return $this->hasOne('Profile', 'user_id');
	}

	public function posts()
	{
		return $this->hasMany('Post', 'user_id');
	}

	public function roles()
	{
		return $this->belongsToMany('Role');
	}
}