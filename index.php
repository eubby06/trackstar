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
define('PATH_APP', PATH_ROOT . DS . 'App');
define('PATH_CORE', PATH_ROOT . DS . 'Core');
define('PATH_VENDOR', PATH_ROOT . DS . 'Vendor');
define('PATH_VIEW', PATH_APP . DS . 'views' . DS);
define('PATH_CONFIG', PATH_APP . DS . 'config' . DS);

require PATH_CORE . DS . 'Bootstrap.php';