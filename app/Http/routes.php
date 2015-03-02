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

use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

// assign what urls use what controller and method
Route::get('/',['as'=>'home','uses'=>'HomeController@index']);
Route::get('/dashboard',['as'=>'dashboard','uses'=>"DashBoardController@index"]);
<<<<<<< HEAD
Route::get('/orders/import',['as' => 'orders.import', 'uses'=>"OrdersController@import"]);
Route::post('/orders/upload',['uses'=>"OrdersController@upload"]);
=======
<<<<<<< HEAD
Route::get('/orders/import',['as' => 'orders.import', 'uses'=>"OrdersController@import"]);
Route::post('/orders/upload',['uses'=>"OrdersController@upload"]);
=======
<<<<<<< HEAD
Route::get('/orders/import',['as' => 'orders.import', 'uses'=>"OrdersController@import"]);
Route::post('/orders/upload',['uses'=>"OrdersController@upload"]);
=======
<<<<<<< HEAD
Route::get('/orders/import',['as' => 'orders.import', 'uses'=>"OrdersController@import"]);
Route::post('/orders/upload',['uses'=>"OrdersController@upload"]);
=======
<<<<<<< HEAD
Route::get('/orders/import',['as' => 'orders.import', 'uses'=>"OrdersController@import"]);
Route::post('/orders/upload',['uses'=>"OrdersController@upload"]);
=======
Route::post('/orders/import',['uses'=>"OrdersController@import"]);

Route::post('/orders/import', function(){

	$pdo = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
	$pdo->query('CREATE TABLE IF NOT EXISTS user (id INT, `name` VARCHAR(255), email VARCHAR(255))');

	$config = new LexerConfig();
	$lexer = new Lexer($config);

	$interpreter = new Interpreter();

	$interpreter->addObserver(function(array $columns) use ($pdo) {
		$checkStmt = $pdo->prepare('SELECT count(*) FROM user WHERE id = ?');
		$checkStmt->execute(array(($columns[0])));

		$count = $checkStmt->fetchAll()[0][0];

		if ($count === '0') {
			$stmt = $pdo->prepare('INSERT INTO user (id, name, email) VALUES (?, ?, ?)');
			$stmt->execute($columns);
		}
	});

	$lexer->parse(Input::file('file'), $interpreter);

	return Redirect::route('orders.index')->with('message', 'Orders imported successfully');
 
});
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master

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
