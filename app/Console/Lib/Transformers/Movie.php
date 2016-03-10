<?php namespace App\Lib\Transformers;

/**
 * Class Movie
 * @package App\Lib\Transformers
 */
class Movie extends Transformer
{
	/**
	 * List of resources possible to include
	 *
	 * @var array
	 */
	protected $defaultIncludes = [];

	/**
	 * @param $item
	 * @param null $originObject
	 * @return array
	 */
	protected function transformItem($item, $originObject = null)
	{
		return [
			'title' => $item['title'],
			'description' => $item['description'],
			'imdb_rating' => (float) $item['imdb_rating'],
			'imdb_votes' => (integer) $item['imdb_votes'],
			'poster' => $item['poster'],
		];
	}
}