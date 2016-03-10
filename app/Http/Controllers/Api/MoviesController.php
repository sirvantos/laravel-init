<?php namespace App\Http\Controllers\Api;

use App\Lib\Transformers\Movie;
use App\Repositories\Criterias\Search;
use App\Repositories\MovieRepositoryEloquent;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Class MoviesController
 * @package App\Http\Controllers\Api
 *
 */
class MoviesController extends Controller
{
	use Helpers;

    /**
	 * @param MovieRepository $repository
	 */
	public function __construct(MovieRepositoryEloquent $repository)
    {
	    parent::__construct();

	    $this->setRepository($repository);
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    $this->
	        repository->
	            setCriteriaValues(['title' => $request->input('queries.q', '')], 'search')->
	            setCriteriaValues(['title' => 'desc'], 'order');

	    return $this->esSearch($request->input('page', 1), $request->input('perPage', self::PER_PAGE));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	/**
	 * @param Request $request
	 * @return mixed
	 */
	public function autoComplete(Request $request)
	{

		$this->
			repository->
				setCriteriaValues(['title' => $request->input('q', '')], 'search')->
				setCriteriaValues(['title' => 'desc'], 'order');

		return $this->esSearch(1, self::PER_PAGE);
	}
}