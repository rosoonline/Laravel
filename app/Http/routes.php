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

// assign what urls use what control and method
Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
Route::get('/dashboard',['as'=>'dashboard','uses'=>"DashBoardController@index"]);

// assign names to controllers
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// Provide controller methods with object instead of ID
Route::model('tasks', 'Task');
Route::model('projects', 'Project');


Route::resource('projects', 'ProjectsController');
Route::resource('projects.tasks', 'TasksController');

// let the first part of the url within projects/tasks be the slug name of the item
Route::bind('projects', function($value, $route) {
	return App\Project::whereSlug($value)->first();
});

Route::bind('tasks', function($value, $route) {
	return App\Task::whereSlug($value)->first();
});
