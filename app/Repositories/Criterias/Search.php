<?php namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AllNoteCriteria
 */
class Search implements CriteriaInterface
{

	/**
	 * @param $model
	 * @param RepositoryInterface $repository
	 * @return mixed
	 */
	public function apply($model, RepositoryInterface $repository)
	{
		$orderBy = $repository->validateRequest()->getCriteriaValues('order');
		$searchBy = $repository->validateRequest()->getCriteriaValues('search');

		$query = $model->query();

		if ($orderBy)
		{
			foreach ($orderBy as $order => $direction)
			{
				$query->orderBy($order, $direction);
			}
		}

		if ($searchBy)
		{
			foreach ($searchBy as $column => $value)
			{
				if ($value)
				{
					$query->where($column, 'ilike', "%{$value}%");
				}
			}
		}

		return $query;
	}
}