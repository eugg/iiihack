<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('events', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('summary');
			$table->datetime('start_time')->nullable();
			$table->datetime('end_time')->nullable();
			$table->text('attendees')->nullable();
			$table->integer('restaurant_id');
			$table->string('location')->nullable();
			$table->string('google_event_id');
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
		//
		Schema::drop('events');
	}

}
