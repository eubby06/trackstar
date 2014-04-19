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
define('PATH_APP', PATH_ROOT . DS . 'app');
define('PATH_CORE', PATH_ROOT . DS . 'core');
define('PATH_CACHE', PATH_ROOT . DS . 'cache');
define('PATH_CONFIG', PATH_ROOT . DS . 'config');
define('PATH_PLUGINS', PATH_ROOT . DS . 'plugins');
define('PATH_SKINS', PATH_ROOT . DS . 'skins');
define('PATH_UPLOADS', PATH_ROOT . DS . 'uploads');

require PATH_CORE . DS .'Bootstrap.php';