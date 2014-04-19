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

// set dsn for pdo connection
$dsn = array(
	'dbname' 	=> 'framework', 
	'username' 	=> 'admin', 
	'password' 	=> 'admin'
	);

// store core settings
$registry->storeSetting($dsn, 'DSN');

// register core classes
$registry->storeObject('Core\\Request', 'CoreRequest');
$registry->storeObject('Core\\Response', 'CoreResponse');
$registry->storeObject('Core\\Router', 'CoreRouter');
$registry->storeObject('Core\\Database\\PDOMapper', 'CorePDOMapper');
$registry->storeObject('Core\\Database\\MysqlGrammar', 'CoreDatabaseGrammar');

// get core objects
$CoreRequest 			= $registry->getObject('CoreRequest');
$CoreResponse 			= $registry->getObject('CoreResponse');
$CoreRouter 			= $registry->getObject('CoreRouter');
$CorePDOMapper 			= $registry->getObject('CorePDOMapper');
$CoreDatabaseGrammar 	= $registry->getObject('CoreDatabaseGrammar');

// require use-defined routes
require PATH_APP . DS .'router.php';

// TESTING IS GOING ON HERE
$query = new Core\Database\QueryBuilder($CoreDatabaseGrammar, $CorePDOMapper);

$query->select('username')
		->from('users')
		->where('id','=',1)
		->run();

die(); //TESTING ENDS HERE


// dispatch request
try {

	$CoreRouter->dispatch();

} catch(\Exception $err) {

	die('Caught exception: ' . $err->getMessage());

}