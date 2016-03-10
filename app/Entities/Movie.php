<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Movie
 * @package App\Entities
 */
class Movie extends Model implements Transformable
{
    use TransformableTrait;

	/**
	 * @var array
	 */
	protected $fillable = [];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = ['id', 'created_at', 'updated_at'];

	/**
	 *
	 */
	public static function boot()
	{
		Movie::created(function ($movie) {
			$params = [];

			$params['body'] = $movie->toArray();

			$params['index'] = 'myimdb';
			$params['type'] = 'movies';

			$params['id'] = $movie->id;

			app('elasticsearch')->index($params);
		});

		Movie::updated(function ($movie) {
			$params = [];

			$params['body']  = $movie->toArray();

			$params['index'] = 'myimdb';
			$params['type'] = 'movies';

			$params['id']    = $movie->id;

			app('elasticsearch')->update($params);
		});

		Movie::deleting(function ($movie) {
			$deleteParams = [];

			$deleteParams['index'] = 'myimdb';
			$deleteParams['type'] = 'movies';
			$deleteParams['id'] = (int) $movie->id;

			app('elasticsearch')->delete($deleteParams);
		});
	}

}
