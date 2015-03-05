<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// extras
use DB;
use App\Order;
use Redirect;
use Input;

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
		$month 			= str_pad(\Request::input('month', date('m')), 2, "0", STR_PAD_LEFT);
		$year 			= \Request::get('year',date('Y'));

		$orders 		= Order::where('date', '=', $year.'-'.$month.'-01')->get();
		return view('orders.index', compact('orders'))->with('month', $month)->with('year', $year);
		//return view('orders.index', array('orders' => $orders));
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function graph()
	{
		$month 			= str_pad(\Request::input('month', date('m')), 2, "0", STR_PAD_LEFT);
		$year 			= \Request::get('year',date('Y'));

		$orders 		= Order::select(DB::raw('customer_code, product, SUM(sales) as totalSales'))
								->where('date', '=', $year.'-'.$month.'-01')
								->groupBy('customer_code','product')
								->get();
								
		$customer_codes		= Order::select(DB::raw('customer_code as code'))
								->where('date', '=', $year.'-'.$month.'-01')	
								->groupBy('customer_code')
								->get();
								
		return view('orders.graph', compact('orders'))->with('month', $month)->with('year', $year)->with('customer_codes', $customer_codes);
		//return view('orders.index', array('orders' => $orders));
	}
	
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
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
