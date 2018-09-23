<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 13:41
 */

namespace Service;


use Core\Service\ConfigManager;
use Predis\Client;

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
        $this->connection = new Client([
            'scheme' => 'tcp',
            'host'   => $envConf->getRedisHost(),
            'port'   => $envConf->getRedisPort(),
        ]);
	}


	public function getConnection(): Client
	{
		return $this->connection;
	}
}