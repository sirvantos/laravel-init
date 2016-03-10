<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddMovies extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('movies', function (Blueprint $table) {
			$table->increments('id');

			$table->string('title', 255);
			$table->string('imdb_id', 32);
			$table->string('type', 8);

			$table->text('description')->nullable();

			$table->smallInteger('year')->nullable();
			$table->date('released')->nullable();
			$table->string('country', 64)->nullable();
			$table->string('language', 64)->nullable();
			$table->float('imdb_rating', 4, 2)->nullable();
			$table->integer('imdb_votes')->nullable();
			$table->text('poster')->nullable();

			$table->index(['title', 'imdb_id', 'type']);

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
		Schema::drop('movies');
	}
}