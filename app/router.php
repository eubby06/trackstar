<?php

use Core\Router;

/*
Router::get('test', function(){

	echo 'hi from router';

});
*/

Router::get('/', 'App\\Controllers\\TestController@getIndex');
Router::get('test', 'App\\Controllers\\TestController@getIndex');
Router::get('test/create', 'App\\Controllers\\TestController@getCreate');