<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 13:41
 */

namespace Service;


use Core\Service\ConfigManager;

class RedisConnection
{

	/**
	 * @var \Redis
	 */
	private $connection;

	/**
	 * @var \Core\Service\ConfigManager
	 */
	private $configManager;

	public function __construct(ConfigManager $configManager)
	{
		$this->configManager = $configManager;
		$envConf = $this->configManager->get()->getEnvConf();
		$this->connection = new \Redis();
		$this->connection->connect($envConf->getRedisHost(),$envConf->getRedisPort());
		$this->connection->auth($envConf->getRedisPassword());
	}

	/**
	 * @return \Redis
	 */
	public function getConnection(): \Redis
	{
		return $this->connection;
	}
}