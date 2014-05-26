<?php

use Core\Router\Route;

Route::get('create', '\\App\\Controllers\\BlogController@createAction');

Route::get('store', '\\App\\Controllers\\BlogController@storeAction');