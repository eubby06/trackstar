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

$users = $users->sortBy('username');

foreach($users as $user)
{
	echo $user->username . '<br />';
}

/*
$user = $q->select('*')
		->from('users')
		->whereBetween('username', 10, 20)
		->getAll();

print_r($user);


$q->insert('users')
	->data(array(
		'username' => 'eubby',
		'password' => 'robs'
		))
	->execute();
*/

/*
$q->update('users')
	->set(array(
		'username' => 'eubbynew'
		))
	->where('id','=',2)
	->execute();
*/

/*
$q->delete('users')
	->where('id','=',1)
	->execute();
*/