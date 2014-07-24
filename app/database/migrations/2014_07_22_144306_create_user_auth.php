<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAuth extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('user_auth', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->string('service', 20);
			$table->string('uid', 255);
			$table->string('accessToken', 1024)->nullable();
			$table->integer('endOfLife')->nullable();
			$table->string('refreshToken', 255)->nullable();
			$table->string('requestToken', 255)->nullable();
			$table->string('requestTokenSecret', 255)->nullable();
			$table->text('extraParams', 65535)->nullable();
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
		Schema::drop('user_auth');
	}

}
