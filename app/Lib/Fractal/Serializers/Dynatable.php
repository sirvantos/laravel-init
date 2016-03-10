<?php namespace App\Lib\Fractal\Serializers;

use League\Fractal\Serializer\ArraySerializer;

/**
 * Class Custom
 * @package App\Lib\Fractal\Serializers
 */
class Dynatable extends ArraySerializer
{
	/**
	 * Serialize a collection.
	 *
	 * @param string $resourceKey
	 * @param array  $data
	 *
	 * @return array
	 */
	public function collection($resourceKey, array $data)
	{
		return array($resourceKey ?: 'records' => $data);
	}

	/**
	 * Serialize the meta.
	 *
	 * @param array $meta
	 *
	 * @return array
	 */
	public function meta(array $meta)
	{
		if (empty($meta))
		{
			return array();
		}

		$data = [];

		if (isset($meta['pagination']))
		{
			$pagination = $meta['pagination'];

			$data = [
				'queryRecordCount' => array_get($pagination, 'total'),
				'queryRecordTotal' => array_get($pagination, 'count'),
				'page' => array_get($pagination, 'current_page'),
				'perPage' => array_get($pagination, 'per_page')
			];

			unset($meta['pagination']);
		}

		return array_merge($data, ['meta' => $meta]);
	}
}