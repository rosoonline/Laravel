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
		$this->month 	= Input::get('month');
		$this->month 	= str_pad($this->month, 2, "0", STR_PAD_LEFT);
		$this->year 	= Input::get('year');
		DB::delete('DELETE from orders WHERE `date`=\''.$this->year.'-'.$this->month.'-00\'');
		
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
				$columns[4] = $this->year.'-'.$this->month.'-00';
				$columns[5] = date('Y-m-d H:i:s');
				$stmt->execute($columns);
			//}
		});

		$lexer->parse(Input::file('file'), $interpreter);
		return true;
		
	}

}
