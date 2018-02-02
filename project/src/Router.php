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
	 * @var RoutingManager
	 */
	private $routingManager;

	/**
	 * Router constructor.
	 * @throws \RuntimeException
	 */
	public function __construct()
	{
		$this->routingManager = new RoutingManager();
		$this->routeAnalyzer = new UrlAnalyzer($_SERVER['REQUEST_URI']);
		$this->routeAnalyzer->processing();
		var_dump($this->getPathRoute());
	}

	/**
	 * @return array
	 */
	public function getRoutingManager(): RoutingManager
	{
		return $this->routingManager;
	}

	/**
	 * @return \UrlAnalyzer
	 */
	public function getRouteAnalyzer(): UrlAnalyzer
	{
		return $this->routeAnalyzer;
	}

	/**
	 * @return null|RoutingPath
	 */
	public function getPathRoute(): ?RoutingPath
	{
		$validator = new RouterValidator();
		foreach ($this->routingManager->getRoutingList()->getAll() as $item) {
			$valid = $validator->checkRoute($this->routeAnalyzer ,$item->getPathAnalyzer());
			if($valid === true){
				return $item;
			}
		}
		return null;
	}
}