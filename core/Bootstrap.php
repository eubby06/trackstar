<?php

// prevent this file from being accessed directly
if (!defined('IN_FRAMEWORK')) exit;

// require autloader
require PATH_CORE . DS .'Autoloader' . DS . 'Autoloader.php';

// register autloader class and method
spl_autoload_extensions( '.php' ); 
spl_autoload_register( 'Autoloader::load');

// initialize service provider
$serviceProvider = new \Core\ServiceProvider();
$serviceProvider->run();