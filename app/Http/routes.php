<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', ['as' => 'root', 'uses' => 'LabelsController@create']);
Route::get('/home', ['as' => 'home', 'uses' => 'LabelsController@create']);

Route::get('/label', ['as' => 'labels.show', 'uses' => 'LabelsController@show']);

Route::resource('users', 'UsersController');

Route::post('couriers/restore/{id}', ['as' => 'couriers.restore', 'uses' => 'CouriersController@restore']);
Route::delete('couriers/remove-institutions/{id}', ['as' => 'couriers.remove-institutions', 'uses' => 'CouriersController@removeInstitutions']);
Route::resource('couriers', 'CouriersController');

Route::post('institutions/index', ['as' => 'institutions.filtered-index', 'uses' => 'InstitutionsController@filteredIndex']);
Route::get('institutions/upload', ['as' => 'institutions.upload', 'uses' => 'InstitutionsController@upload']);
Route::post('institutions/upload', ['as' => 'institutions.import', 'uses' => 'InstitutionsController@import']);
Route::get('institutions/list.json', ['as' => 'institutions.list', 'uses' => 'InstitutionsController@listJson']);
Route::resource('institutions', 'InstitutionsController');

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@getLogout']);

// Registration routes...
Route::get('auth/register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@getRegister']);
Route::post('auth/register', ['as' => 'auth.postRegister', 'use' => 'Auth\AuthController@postRegister']);
