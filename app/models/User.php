<?php namespace App\Models;

class User extends Base
{
	protected $table = 'users';

	public $rules = array(
			'firstname' => 'required',
			'lastname' 	=> 'required',
			'email' 	=> 'required|email',
			'username' 	=> 'required',
			'password' 	=> 'required'
		);

	public function profile()
	{
		return $this->hasOne('\\App\\Models\\Profile', 'user_id');
	}

	public function posts()
	{
		return $this->hasMany('\\App\\Models\\Post', 'user_id');
	}

	public function roles()
	{
		return $this->belongsToMany('\\App\\Models\\Role');
	}

	public function validate($attributes)
	{
		$this->validator->validate($attributes);

		if ($this->validator->passes())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}