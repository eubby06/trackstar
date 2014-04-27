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
}

$model = new User();

$users = $model->findAll();

$sortedUsers = $users->sortBy('username');

$filteredUsers = $sortedUsers->filter(function($user)
{
	return $user->username !== 'bubby';
});

$filteredUsers->each(function($user)
{
	echo $user->username . '<br />';
});