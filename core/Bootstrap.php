<?php

// prevent this file from being accessed directly
if (!defined('IN_FRAMEWORK')) exit;

// require autloader
require PATH_CORE . DS .'Autoloader.php';

// register autloader class and method
spl_autoload_extensions( '.php' ); 
spl_autoload_register( 'Autoloader::load');

// get registry object
$registry = Core\Registry::singleton();

// register core classes
$registry->storeObject('Core\\Request', 'CoreRequest');
$registry->storeObject('Core\\Response', 'CoreResponse');
$registry->storeObject('Core\\Router', 'CoreRouter');

// get core objects
$CoreRequest 		= $registry->getObject('CoreRequest');
$CoreResponse 		= $registry->getObject('CoreResponse');
$CoreRouter 		= $registry->getObject('CoreRouter');

// require use-defined routes
require PATH_APP . DS .'router.php';

// initialize data mapper and model
$adapter 	= new Core\Database\MysqlAdapter("mysql:dbname=framework", "admin", "admin");
$model = new Core\Model($adapter);

// store adapter and model to registry
$registry->storeObject($adapter, 'DBAdapter');
$registry->storeObject($model, 'CoreModel');

// dispatch request
try {

	$CoreRouter->dispatch();

} catch(\Exception $err) {

	die('Caught exception: ' . $err->getMessage());

}