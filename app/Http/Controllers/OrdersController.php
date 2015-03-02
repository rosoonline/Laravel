<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
use Illuminate\Http\Request;

// extras
use App\Order;
<<<<<<< HEAD
use Redirect;
use Input;

=======
<<<<<<< HEAD
use Redirect;
use Input;

=======
<<<<<<< HEAD
use Redirect;
use Input;

=======
<<<<<<< HEAD
use Redirect;

=======
<<<<<<< HEAD
use Redirect;

=======
use Input;
use Redirect;

<<<<<<< HEAD
use PDO;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;

=======
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
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
<<<<<<< HEAD
		$month 			= str_pad(\Request::input('month', date('m')), 2, "0", STR_PAD_LEFT);
		$year 			= \Request::get('year',date('Y'));

		$orders 		= Order::where('date', '=', $year.'-'.$month.'-01')->get();
		return view('orders.index', compact('orders'))->with('month', $month)->with('year', $year);
		//return view('orders.index', array('orders' => $orders));
	}
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master
		$currentmonth 			= str_pad(\Request::input('month', date('m')), 2, "0", STR_PAD_LEFT);
		$currentyear 			= \Request::get('year',date('Y'));

		$orders 				= Order::where('date', '=', '-01')->get();
		return view('orders.index', compact('orders'))->with('currentmonth', $currentmonth)->with('currentyear', $currentyear);
		//return view('orders.index', array('orders' => $orders));
	}
<<<<<<< HEAD
=======
=======
		$orders = Order::all();
		return view('orders.index', compact('orders'));
	}
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	
	}
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
	public function import()
	{
		//$orders = Order::all();
		return view('orders.import', compact('orders'));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function upload()
	{
		if (Order::upload()) {
			return Redirect::route('dashboard')->with('message', 'Orders imported successfully');
		} else {return Redirect::route('dashboard')->withErrors('Orders did not get imported');}
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
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
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
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
<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
		//
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
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
