<?php

// Copyright 2014 Yonanne Remedio
// This file is part of trackstar framework

session_start();

error_reporting(E_ALL);

define('IN_FRAMEWORK', 1);
define('START_TIME', microtime(true));
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('PATH_ROOT', dirname(__FILE__));
define('PATH_CORE', PATH_ROOT . DS . 'Core');

require PATH_CORE . DS . 'Bootstrap.php';

class User extends \Core\Database\TSModelAbstract
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

class Profile extends \Core\Database\TSModelAbstract
{
	protected $table = 'profiles';

	public function user()
	{
		return $this->belongsTo('User', 'user_id');
	}
}

class Post extends \Core\Database\TSModelAbstract
{
	protected $table = 'posts';
}

class Role extends \Core\Database\TSModelAbstract
{
	protected $table = 'roles';

	public function users()
	{
		return $this->belongsToMany('User');
	}
}

$model = new User();

$user = $model->findById(1);

$roles = $user->roles;

$roles->each(function($role)
{
	$role->pivot->description = 'this is bsd';
	$role->pivot->save();
});

require 'vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$response = new Response('Not Found', 404, array('Content-Type' => 'text/plain'));
$response->send();