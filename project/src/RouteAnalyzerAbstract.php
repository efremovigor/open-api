<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 11:49
 */

abstract class RouteAnalyzerAbstract
{

	/**
	 * @var string
	 */
	protected $route;

	/**
	 * @var array
	 */
	protected $parts = [];


	public function __construct(string $route)
	{
		$this->route = $route;
	}

	abstract public function processing(): void;

	/**
	 * @return string
	 */
	public function getRoute(): string
	{
		return $this->route;
	}

}