<?php namespace App\Lib\Transformers;

use App;
use League\Fractal\TransformerAbstract;

/**
 * Class Transformer
 * @package App\Lib\Transformers
 */
class Transformer extends TransformerAbstract
{
	/**
	 * @return null
	 */
	public function transform($item)
	{
		$transformed = [];
		if (!$item) {
			$this->setAvailableIncludes([])->setDefaultIncludes([]);
			return $transformed;
		}

		$originObject = null;
		if (!is_array($item)) {
			$originObject = $item;
			$item = $item->toArray();
		}

		if (!App::runningUnitTests()) {
			if (!empty($item['id'])) {
				$transformed['id'] = (int)$item['id'];
			}
			if (!empty($item['created_at'])) {
				$transformed['created_at'] = $item['created_at'];
			}
			if (!empty($item['updated_at'])) {
				$transformed['updated_at'] = $item['updated_at'];
			}
		}

		return array_merge($transformed, $this->transformItem($item, $originObject));
	}

	/**
	 * @param $item
	 * @param null $originObject
	 * @return array
	 */
	protected function transformItem($item, $originObject = null)
	{
		return [];
	}

	/**
	 * @param $item
	 * @param $property
	 * @param Transformer $transformer
	 * @return \League\Fractal\Resource\Item
	 */
	protected function subItem($item, $property, Transformer $transformer)
	{
		if (is_array($item)) {
			$object = array_get($item, $property, []);
		} else {
			$object = $item->{$property};
		}

		return $this->item($object, $transformer);
	}

	/**
	 * @param $item
	 * @param $property
	 * @param Transformer $transformer
	 * @return \League\Fractal\Resource\Collection
	 */
	protected function subCollection($item, $property, Transformer $transformer)
	{
		return $this->collection(array_get($item, $property, []), $transformer);
	}
}