<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 8:46
 */

class RoutingList extends ACollection
{

	public function __construct(array $elements = [])
	{
		foreach ($elements as $key => $element) {
			parent::set($key, new RoutingPath($element));
		}
	}

	/**
	 * @return RoutingPath[]
	 */
	public function getAll(): array
	{
		return $this->elements;
	}
}