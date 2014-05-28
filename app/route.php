<?php

use Core\Router\Route;

Route::get('create', '\\App\\Controllers\\BlogController@create');

Route::get('store', '\\App\\Controllers\\BlogController@store');

// Registration
Route::get('/', '\\App\\Controllers\\RegistrationController@getIndex');
Route::get('register', '\\App\\Controllers\\RegistrationController@getRegister');
Route::post('register', '\\App\\Controllers\\RegistrationController@postRegister');