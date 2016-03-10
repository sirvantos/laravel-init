<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Entities\Movie::class, function (Faker\Generator $faker) {
	return [
		'title' => $faker->sentence(rand(1, 4)),
		'description' => $faker->paragraph(6),
		'imdb_id' => str_random(8),
		'type' => 'movie',
		'released' => $faker->date,
		'country' => 'us',
		'imdb_rating' => rand(1, 10),
		'imdb_votes' => $faker->randomNumber(6),
		'poster' => '/img/MV5BMjE0NTA2MTEwOV5BMl5BanBnXkFtZTgwNzg4NzU2NjE@._V1_SX214_AL_.jpg'
	];
});