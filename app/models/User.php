<?php namespace App\Models;

class User extends Base
{
	protected $table = 'users';

	public $rules = array(
		'username' 	=> 'required|min:2|unique:users',
		'password' 	=> 'required|numeric|max:8',
		'email'		=> 'email'
		);

	public $attributes = array(
		'username' 	=> 'johndoes',
		'password' 	=> '12334343',
		'email' 	=> 'admin@yahoo.com'
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

	public function save()
	{
		$this->validator->validate();

		if ($this->validator->passes())
		{
			echo 'passes';
		}
		else
		{
			print_r($this->validator->errors());
		}
	}
}