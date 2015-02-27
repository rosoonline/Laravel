<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('customer_code')->default('');
<<<<<<< HEAD
			$table->date('date')->default('000-00-00');
=======
<<<<<<< HEAD
			$table->date('date')->default('000-00-00');
=======
<<<<<<< HEAD
			$table->date('date')->default('000-00-00');
=======
>>>>>>> origin/master
>>>>>>> origin/master
>>>>>>> origin/master
			$table->integer('sales')->unsigned()->default(0);
			$table->decimal('revenue', 5, 2)->default('00.00');
			$table->string('product')->default('');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('orders');
	}

}
