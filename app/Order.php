<?php namespace App;

use Illuminate\Database\Eloquent\Model;

<<<<<<< HEAD
// extras
use PDO;
use Goodby\CSV\Import\Standard\Lexer;
use Goodby\CSV\Import\Standard\Interpreter;
use Goodby\CSV\Import\Standard\LexerConfig;
use Input;

class Order extends Model {

	protected function upload() {
		
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
				$month 	= Input::get('month');
				$month 	= str_pad($month, 2, "0", STR_PAD_LEFT);
				$year 	= Input::get('year');
				$stmt = $pdo->prepare('INSERT INTO orders (customer_code, sales, revenue, product, date) VALUES (?, ?, ?, ?, ?)');
				$columns[4] = $year.'-'.$month.'-00';
				$stmt->execute($columns);
			//}
		});

		$lexer->parse(Input::file('file'), $interpreter);
		return true;
		
	}
=======
class Order extends Model {

<<<<<<< HEAD
	protected function ordersImport() {
		
	}
=======
	//
>>>>>>> origin/master
>>>>>>> origin/master

}
