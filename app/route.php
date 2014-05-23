<?php

use Core\Router\Route;

Route::get('/', '\\App\\Controllers\\BlogController@indexAction');

Route::get('view', '\\App\\Controllers\\BlogController@viewAction');