<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
=======

>>>>>>> origin/master
use Illuminate\Http\Request;

// extras
use App\Order;
use Input;
use Redirect;

<<<<<<< HEAD
use PDO;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

=======
>>>>>>> origin/master
class OrdersController extends Controller {

	 /**
	* Create a new controller instance.
	*
	* @return void
	*/
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$orders = Order::all();
		return view('orders.index', compact('orders'));
	}
<<<<<<< HEAD
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	
	}
=======
>>>>>>> origin/master

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
<<<<<<< HEAD
	public function import()
	{
		$pdo = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);

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
=======
	public function create()
	{
		//
>>>>>>> origin/master
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
