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

// assign what urls use what controller and method
Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
Route::get('/dashboard',['as'=>'dashboard','uses'=>"DashBoardController@index"]);
Route::get('/orders/import',['as' => 'orders.import', 'uses'=>"OrdersController@import"]);
Route::post('/orders/upload',['uses'=>"OrdersController@upload"]);
Route::get('/orders/graph',['uses'=>"OrdersController@graph"]);

// assign names to controllers to use. auth and password are compulsory for authentication
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

// route model binding - Provide controller methods with access to model object by name instead of ID
Route::model('tasks', 'Task');
Route::model('projects', 'Project');
Route::model('orders', 'Order');

// make the projects and tasks controller available to the following routes/nested routes so they have RESTful actions, such as create, edit etc
// resource controllers are made available to routes that require CRUD for example.
Route::resource('projects', 'ProjectsController');
Route::resource('projects.tasks', 'TasksController');
Route::resource('orders', 'OrdersController');

// let the first part of the url within projects/tasks be the slug name of the item
Route::bind('projects', function($value, $route) {
	return App\Project::whereSlug($value)->first();
});

Route::bind('tasks', function($value, $route) {
	return App\Task::whereSlug($value)->first();
});
