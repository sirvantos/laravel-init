<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActors extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actors', function (Blueprint $table) {
			$table->increments('id');

			$table->string('name', 255);
			$table->string('type', 16);

			$table->unsignedInteger('movie_id');

			$table->foreign('movie_id')->references('id')->on('users')->onDelete('cascade');

			$table->index(['name', 'type', 'movie_id']);

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
		Schema::drop('actors');
	}
}
