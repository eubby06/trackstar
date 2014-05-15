<?php namespace App\Models;

class Role extends Base
{
	protected $table = 'roles';

	public function users()
	{
		return $this->belongsToMany('User');
	}
}