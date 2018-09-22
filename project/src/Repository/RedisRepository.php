<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 13:06
 */

namespace Repository;


use Core\Service\Serializer;
use Entity\User;
use Service\RedisConnection;

class RedisRepository
{

	/**
	 * @var \Core\Service\Serializer
	 */
	private $serializer;

	/**
	 * @var \Service\RedisConnection
	 */
	private $redisConnection;

	public function __construct(RedisConnection $redisConnection, Serializer $serializer)
	{
		$this->serializer = $serializer;
		$this->redisConnection = $redisConnection;
	}

	/**
	 * @param string $sessionKey
	 *
	 * @return \Entity\User|null
	 * @throws \Exception
	 */
	public function getBySession(string $sessionKey): ?User
	{
		return $this->serializer->normalize($this->redisConnection->getConnection()->get('user_session_' . $sessionKey), User::class);
	}
}