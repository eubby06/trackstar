<?php namespace App\Models;

class Profile extends Base
{
	protected $table = 'profiles';

	public function user()
	{
		return $this->belongsTo('\\App\\Models\\User', 'user_id');
	}
}