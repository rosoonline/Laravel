<?php namespace App;

use Illuminate\Database\Eloquent\Model;

// extras
use DB;
use PDO;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Input;

class Order extends Model {

	protected function upload() {
		
		// remove any orders previously imported with the same year/month
		$this->month 	= str_pad(Input::get('month'), 2, "0", STR_PAD_LEFT);
		$this->year 	= Input::get('year');
		DB::delete('DELETE from orders WHERE `date`=\''.$this->year.'-'.$this->month.'-01\'');
		
		// open PDO connection and do import
		$pdo = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
		
		$config = new LexerConfig();
		$lexer = new Lexer($config);

		$interpreter = new Interpreter();
		$interpreter->unstrict(); // Ignore row column count consistency

		$interpreter->addObserver(function(array $columns) use ($pdo) {
		
			//$checkStmt = $pdo->prepare('SELECT count(*) FROM orders WHERE id = ?');
			//$checkStmt->execute(array(($columns[0])));

			//$count = $checkStmt->fetchAll()[0][0];
			
			//if ($count === '0') {
				$stmt = $pdo->prepare('INSERT INTO orders (customer_code, sales, revenue, product, date, created_at) VALUES (?, ?, ?, ?, ?, ?)');
				$columns[4] = $this->year.'-'.$this->month.'-01';
				$columns[5] = date('Y-m-d H:i:s');
				$stmt->execute($columns);
			//}
		});

		$lexer->parse(Input::file('file'), $interpreter);
		return true;
		
	}
	
	protected function getCanvasData($viewaxis) {
	
		$month 			= str_pad(\Request::input('month', date('m')), 2, "0", STR_PAD_LEFT);
		$year 			= \Request::get('year',date('Y'));
	
		$customer_codes		= Order::select(DB::raw('customer_code as code'))
					->where('date', '=', $year.'-'.$month.'-01')	
					->groupBy('customer_code')
					->orderBy('customer_code', 'ASC')
					->get();
	
		if ($viewaxis=='pc_sales' || $viewaxis=='cp_sales') {
		$orders 		= Order::select(DB::raw('customer_code, product, SUM(sales) as total'))
								->where('date', '=', $year.'-'.$month.'-01')
								->groupBy('customer_code','product')
								->orderBy('customer_code', 'DESC')
								->get();								
		}
		
		if ($viewaxis=='pc_revenue' || $viewaxis=='cp_revenue') {
			$orders 	= Order::select(DB::raw('customer_code, product, SUM(revenue) as total'))
								->where('date', '=', $year.'-'.$month.'-01')
								->groupBy('customer_code','product')
								->orderBy('customer_code', 'DESC')
								->get();
		}
		
		if ($orders) {
			foreach ($orders as $order) {
				$products[$order->product][] = array('label' => $order->customer_code , 'y' => strval($order->total));
			}
		}
		
		$string = (string)'';
		
		if ($viewaxis=='pc_sales' || $viewaxis=='pc_revenue') {
			foreach ($customer_codes as $customer_code=>$customer) { // typically $key=>$value
				$data_points = array();
				$string .= '
				  {
					type: "stackedBar",
					name: "'.$customer['code'].'",
					showInLegend: false,
					dataPoints: 
				';
					
				foreach ($products as $productname=>$order) {
					$datapoint = 0;
					for ($k = 0; $k < count($order); $k++) {
						if ($customer['code']==$order[$k]['label']) {
							$datapoint = $order[$k]['y'];
						}
					}
					$point = array("label" => $productname, "y" => $datapoint);
					array_push($data_points, $point);
				}
				
				$string .= json_encode($data_points, JSON_NUMERIC_CHECK);
					
				$string .= '
				  },
				';
			}
		}
		
		if ($viewaxis=='cp_sales' || $viewaxis=='cp_revenue') {
			foreach ($products as $productname=>$order) {
				$data_points = array();
				$string .= '
				  {
					type: "stackedBar",
					name: "'.$productname.'",
					showInLegend: true,
					dataPoints: 
				';
				
				for ($i = 0; $i < count($customer_codes); $i++) {
					$datapoint = 0;
					for ($j = 0; $j < count($order); $j++) {
						if ($order[$j]['label']==$customer_codes[$i]->code) {
							$datapoint = $order[$j]['y'];
						}
					}
					$point = array("label" => $customer_codes[$i]->code, "y" => $datapoint);
					array_push($data_points, $point);
				}

				$string .= json_encode($data_points, JSON_NUMERIC_CHECK);
				
				$string .= '
				  },
				';
			}
		}
		
		return $string;
		
	}
	
	protected function getChartTitle($viewaxis) {
			$chartTitle = (string) '';
			if ($viewaxis=='pc_sales') 		{$chartTitle='Product - Customer sales';}
			if ($viewaxis=='pc_revenue') 	{$chartTitle='Product - Customer revenue (\u00A3)';}
			if ($viewaxis=='cp_sales') 		{$chartTitle='Customer - Product sales';}
			if ($viewaxis=='cp_revenue') 	{$chartTitle='Customer - Product revenue (\u00A3)';}
			return $chartTitle;
	}

}
