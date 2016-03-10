<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Movie;

/**
 * Class MovieRepositoryEloquent
 * @package namespace App\Repositories;
 */
class MovieRepositoryEloquent extends BaseRepositoryEloquent implements MovieRepository
{
	/**
	 * @var array
	 */
	protected $orderableColumns = ['title', 'imdb_rating', 'imdb_votes'];

	/**
	 * @var array
	 */
	protected $searchableColumns = ['title'];

	/**
	 * @var string
	 */
	protected $esType = 'movies';

	/**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Movie::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
