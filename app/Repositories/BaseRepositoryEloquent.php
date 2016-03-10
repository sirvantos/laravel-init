<?php namespace App\Repositories;

use Elasticsearch\Client;
use Illuminate\Http\Request;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class MovieRepositoryEloquent
 * @package namespace App\Repositories;
 */
abstract class BaseRepositoryEloquent extends BaseRepository
{
	/**
	 *
	 */
	const ES_PAGINATION_SIZE = 12;

	/**
	 * @var array
	 */
	protected $orderableColumns = [];

	/**
	 * @var array
	 */
	protected $searchableColumns = [];

	/**
	 * @var array
	 */
	protected $searchValues = [];

	/**
	 * @var Client
	 */
	protected $es = null;

	/**
	 * @var string
	 */
	protected $esIndex = 'myimdb';

	/**
	 * @var string
	 */
	protected $esType = '';

	/**
	 * @param Request $request
	 * @return $this
	 */
	public function setCriteriaValues($values, $type = 'order')
	{
		$this->searchValues[$type] = $values;

		return $this;
	}

	/**
	 * @return Request
	 */
	public function getCriteriaValues($type = 'order')
	{
		if ( ! $this->searchValues)
		{
			throw new \RuntimeException('Please set search values before');
		}

		return array_get($this->searchValues, $type, []);
	}

	/**
	 * @return $this
	 */
	public function validateRequest()
	{
		$this->validateSearchValues()->validateOrderValues();

		return $this;
	}

	/**
	 * @param array $query
	 * @param int $page
	 * @return array
	 */
	public function esPagination($page = 1, $perPage = self::ES_PAGINATION_SIZE)
	{
		$params['index'] = $this->esIndex;
		$params['type']  = $this->esType;

		$matches = [];

		foreach ($this->getCriteriaValues('search') as $value)
		{
			$matches[] = [
				'query_string' => [
					'query' => "combined:{$value}*"
				]
			];
		}

		$filters = [];

		$fullQuery = [
			'index' => $this->esIndex,
			'type'  => $this->esType,
			'body'  => [
				'from' => ($page - 1) * $perPage,
				'size' => (int) $perPage,
				'query' => [
					'filtered' => [
						'filter' => $filters,
						'query' => [
							'bool' => ['should' => $matches]
						]
					]
				],
				'sort' => [
					['title.raw_title' => ['order' => 'asc']]
				]
			]
		];

		$result =  $this->initEs()->search($fullQuery);

		return [
			'queryRecordCount' => array_get($result, 'hits.total', 0),
			'queryRecordTotal' => array_get($result, 'hits.total', 0),
			'page' => $page,
			'perPage' => $perPage,
			'records' => array_get($result, 'hits.hits', [])
		];
	}

	/**
	 * @return $this
	 */
	protected function validateSearchValues()
	{
		$searchBy = array_keys($this->getCriteriaValues('search'));

		if ( $this->searchableColumns && $searchBy && $searchBy != array_intersect($searchBy, $this->searchableColumns))
		{
			throw new \RuntimeException('Not searchable column >' . implode(',', $searchBy) . '<');
		}

		return $this;
	}

	/**
	 * @return $this
	 */
	protected function validateOrderValues()
	{
		$orderBy = array_keys($this->getCriteriaValues('order'));

		if ($this->orderableColumns &&  $orderBy && $orderBy != array_intersect($orderBy, $this->orderableColumns))
		{
			throw new \RuntimeException('Not orderable column >' . $orderBy . '<');
		}

		return $this;
	}

	/**
	 * @return  Client
	 */
	protected function initEs()
	{
		if ( ! $this->es)
		{
			$this->es = app('elasticsearch');
		}

		return $this->es;
	}
}