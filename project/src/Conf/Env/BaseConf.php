<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 14:26
 */

namespace Conf\Env;


use Core\Service\Entity\PropertyAccessInterface;

class BaseConf implements PropertyAccessInterface, EnvConfInterface
{

	protected $isProfiling;

	protected $sqlDsn;

	protected $sqlUser;

	protected $sqlPassword;

	protected $redisHost;

	protected $redisPort;

	protected $redisPassword;

	public function getProperties(): array
	{
		return [
			'isProfiling',
			'sqlDsn',
			'sqlUser',
			'sqlPassword',
			'redisHost',
			'redisPort',
			'redisPassword',
		];
	}

	public function isProfiling(): bool
	{
		return $this->isProfiling;
	}

	/**
	 * @return mixed
	 */
	public function getSqlDsn(): ?string
	{
		return $this->sqlDsn;
	}

	/**
	 * @param mixed $sqlDsn
	 */
	public function setSqlDsn($sqlDsn): void
	{
		$this->sqlDsn = $sqlDsn;
	}

	/**
	 * @return mixed
	 */
	public function getSqlUser(): ?string
	{
		return $this->sqlUser;
	}

	/**
	 * @param mixed $sqlUser
	 */
	public function setSqlUser($sqlUser): void
	{
		$this->sqlUser = $sqlUser;
	}

	/**
	 * @return mixed
	 */
	public function getSqlPassword(): ?string
	{
		return $this->sqlPassword;
	}

	/**
	 * @param mixed $sqlPassword
	 */
	public function setSqlPassword($sqlPassword): void
	{
		$this->sqlPassword = $sqlPassword;
	}

	/**
	 * @return mixed
	 */
	public function getRedisHost() :?string
	{
		return $this->redisHost;
	}

	/**
	 * @param mixed $redisHost
	 */
	public function setRedisHost($redisHost): void
	{
		$this->redisHost = $redisHost;
	}

	/**
	 * @return mixed
	 */
	public function getRedisPort() :?string
	{
		return $this->redisPort;
	}

	/**
	 * @param mixed $redisPort
	 */
	public function setRedisPort($redisPort): void
	{
		$this->redisPort = $redisPort;
	}

	/**
	 * @return mixed
	 */
	public function getRedisUser() :?string
	{
		return $this->redisUser;
	}

	/**
	 * @return mixed
	 */
	public function getRedisPassword() :?string
	{
		return $this->redisPassword;
	}

	/**
	 * @param mixed $redisPassword
	 */
	public function setRedisPassword($redisPassword): void
	{
		$this->redisPassword = $redisPassword;
	}


}