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
	
		$customer_codes	= Order::select(DB::raw('customer_code as code'))
					->where('date', '=', $year.'-'.$month.'-01')	
					->groupBy('customer_code')
					->get();
					
		$product_codes = Order::select(DB::raw('product as code'))
					->where('date', '=', $year.'-'.$month.'-01')	
					->groupBy('product')
					->get();
	
		if ($viewaxis=='pc_sales' || $viewaxis=='cp_sales') {
			$sumField = 'sales';
		}
		if ($viewaxis=='pc_revenue' || $viewaxis=='cp_revenue') {
			$sumField = 'revenue';
		}
		
		// dynamic cross-tab table - generates a table listing all the customers, with each product named as a table column that holds its sales/revenue total
		$query = 'customer_code';
		foreach ($product_codes as $product_code=>$product) {
			$query .= ", SUM(CASE WHEN product = '".$product->code."' THEN ".$sumField." ELSE 0 END) `".$product->code."`";
		}
		
		$customer_orders = Order::select(DB::raw($query))
			->where('date', '=', $year.'-'.$month.'-01')
			->groupBy('customer_code')
			->OrderBy('customer_code','DESC')
			->get(); // toSql();
		// end of cross-tab table
		
		$string = (string)'';
		
		// graph - product vs client sales/revenue
		if ($viewaxis=='pc_sales' || $viewaxis=='pc_revenue') {

				for ($l = 0; $l < count($customer_orders); $l++) {
					$data_points = array();
					$string .= '
					  {
						type: "stackedBar",
						name: "'.$customer_orders[$l]->customer_code.'",
						showInLegend: false,
						dataPoints: 
					';
					
					foreach ($product_codes as $product_code=>$product) {
						$point = array("label" => $product->code, "y" => $customer_orders[$l]->{$product->code}); // pull in columns named after each product dynamically using {}
						array_push($data_points, $point);
					}
					
					$string .= json_encode($data_points, JSON_NUMERIC_CHECK);
					$string .= '
					  },
					';					
				}
		}
		
		// graph - customer vs product sales/revenue
		if ($viewaxis=='cp_sales' || $viewaxis=='cp_revenue') {
		
			foreach ($product_codes as $product_code=>$product) {
				$data_points = array();
				$string .= '
				  {
					type: "stackedBar",
					name: "'.$product->code.'",
					showInLegend: false,
					dataPoints: 
				';

				for ($l = 0; $l < count($customer_orders); $l++) {
					$point = array("label" => $customer_orders[$l]->customer_code, "y" => $customer_orders[$l]->{$product->code}); // pull in columns named after each product dynamically using {}
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
