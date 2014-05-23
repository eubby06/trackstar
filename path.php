<?php

// Copyright 2014 Yonanne Remedio
// This file is part of trackstar framework
define('IN_FRAMEWORK', 1);
define('START_TIME', microtime(true));
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('PATH_ROOT', dirname(__FILE__)  . DS);
define('PATH_APP', PATH_ROOT . 'App' . DS);
define('PATH_CORE', PATH_ROOT . 'Core' . DS);
define('PATH_VENDOR', PATH_ROOT . 'Vendor' . DS);
define('PATH_VIEW', PATH_APP . 'views' . DS);
define('PATH_CONFIG', PATH_APP . 'config' . DS);
define('PATH_STORAGE', PATH_APP . 'storage' . DS);