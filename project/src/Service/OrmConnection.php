<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 13:41
 */

namespace Service;


use Core\Service\ConfigManager;
use PDO;

class OrmConnection
{

	/**
	 * @var PDO
	 */
	private $connection;

	/**
	 * @var \Core\Service\ConfigManager
	 */
	private $configManager;

	public function __construct(ConfigManager $configManager)
	{
		$config = $configManager->get()->getEnvConf();
		$this->connection = new PDO($config->getSqlDsn(),$config->getSqlUser(),$config->getSqlPassword());
		$this->configManager = $configManager;
	}

	/**
	 * @return \PDO
	 */
	public function getConnection(): \PDO
	{
		return $this->connection;
	}
}