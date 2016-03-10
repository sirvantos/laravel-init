<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class Controller
 * @package App\Http\Controllers
 */
abstract class Controller extends BaseController
{
	/**
	 *
	 */
	const PER_PAGE = 15;

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	/**
	 * @var BaseRepository
	 */
	protected $repository = null;

	/**
	 *
	 */
	public function __construct()
	{

	}

	/**
	 * @param BaseRepository $repository
	 *
	 * @return $this
	 */
	public function setRepository(BaseRepository $repository)
	{
		$this->repository = $repository;

		return $this;
	}

	/**
	 * @param Request $request
	 * @param int $page
	 * @param int $perPage
	 * @return mixed
	 */
	protected function esSearch($page = 1, $perPage = self::PER_PAGE)
	{
		return $this->repository->esPagination($page, $perPage);
	}
}
