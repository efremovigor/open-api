<?php


class Kernel
{

	/**
	 * @var Router
	 */
	private $router;


	/**
	 * Kernel constructor.
	 * @throws \RuntimeException
	 */
	public function __construct()
	{
		$this->router = new Router();
	}


	public static function getAppDir(): string
	{
		return __DIR__;
	}

	public static function getRootDir(): string
	{
		return __DIR__ . '/..';
	}

	public static function getCacheDir(): string
	{
		return dirname(__DIR__) . '/var/cache/' . static::getEnvironment();
	}

	/**
	 * @return string
	 */
	public static function getLogDir(): string
	{
		return dirname(__DIR__) . '/var/logs';
	}

	private static function getEnvironment(): string
	{
		return 'prod';
	}

	/**
	 * @return Router
	 */
	public function getRouter(): Router
	{
		return $this->router;
	}

}
