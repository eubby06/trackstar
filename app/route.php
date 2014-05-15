<?php

use Core\Router\Route;

Route::get('/', '\\App\\Controllers\\BlogController@indexAction');

Route::get('blog/view/{id}', '\\App\\Controllers\\BlogController@viewAction');