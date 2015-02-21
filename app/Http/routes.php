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

Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
Route::get('/dashboard',['as'=>'dashboard','uses'=>"DashBoardController@index"]);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::controller('/','Auth\AuthController');

// Provide controller methods with object instead of ID
Route::model('tasks', 'Task');
Route::model('projects', 'Project');

Route::resource('projects', 'ProjectsController');
Route::resource('projects.tasks', 'TasksController');

Route::bind('projects', function($value, $route) {
	return App\Project::whereSlug($value)->first();
});

Route::bind('tasks', function($value, $route) {
	return App\Task::whereSlug($value)->first();
});
