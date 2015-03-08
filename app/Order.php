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
	
	protected function getChartTitle($viewaxis) {
			$chartTitle = (string) '';
			if ($viewaxis=='pc_sales') 		{$chartTitle='Product - Customer sales';}
			if ($viewaxis=='pc_revenue') 	{$chartTitle='Product - Customer revenue (\u00A3)';}
			if ($viewaxis=='cp_sales') 		{$chartTitle='Customer - Product sales';}
			if ($viewaxis=='cp_revenue') 	{$chartTitle='Customer - Product revenue (\u00A3)';}
			return $chartTitle;
	}

}
