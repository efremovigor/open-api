<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 31.01.18
 * Time: 14:32
 */

class Router
{

	private $baseRoute;

	public function __construct()
	{
		$this->baseRoute = $_SERVER['REQUEST_URI'];
	}

	/**
	 * @return string
	 */
	public function getBaseRoute(): string
	{
		return $this->baseRoute;
	}
}