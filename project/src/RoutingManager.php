<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 02.02.18
 * Time: 8:42
 */

class RoutingManager
{

	private $routingList;

	/**
	 * RoutingManager constructor.
	 * @throws \RuntimeException
	 */
	public function __construct()
	{
		$file = (new YmlParser())->getYml(App::getAppDir() . '/config/routing.yml');
		if (!isset($file['routing']['paths']) || !is_array($file['routing']['paths'])) {
			throw new \RuntimeException('Не валидный routing list');
		}
		$this->routingList = new RoutingList($file['routing']['paths']);

	}

	/**
	 * @return \RoutingList
	 */
	public function getRoutingList(): \RoutingList
	{
		return $this->routingList;
	}
}