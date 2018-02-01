<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 31.01.18
 * Time: 14:32
 */

class Router
{

	/**
	 * @var UrlAnalyzer
	 */
	private $routeAnalyzer;

	/**
	 * @var RoutingList
	 */
	private $routingList;

	/**
	 * Router constructor.
	 * @throws \RuntimeException
	 */
	public function __construct()
	{
		$file = (new YmlParser())->getYml(Kernel::getAppDir() . '/config/routing.yml');
		if (!isset($file['routing']['paths']) || !is_array($file['routing']['paths'])) {
			throw new \RuntimeException('Не валидный routing list');
		}
		$this->routeAnalyzer = new UrlAnalyzer($_SERVER['REQUEST_URI']);
		$this->routeAnalyzer->processing();
		$this->routingList = new RoutingList($file['routing']['paths']);
		$validator = new RouterValidator();
		foreach ($this->routingList->getAll() as $item) {
			$validator->checkRoute($this->routeAnalyzer ,$item);
		}

	}

	/**
	 * @return array
	 */
	public function getRoutingList(): RoutingList
	{
		return $this->routingList;
	}

	/**
	 * @return \UrlAnalyzer
	 */
	public function getRouteAnalyzer(): UrlAnalyzer
	{
		return $this->routeAnalyzer;
	}


}