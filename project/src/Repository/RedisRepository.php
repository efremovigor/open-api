<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 13:06
 */

namespace Repository;


use Core\Service\Serializer;
use Entity\GiftBalanceInfo;
use Entity\GiftInterface;
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
        $this->serializer      = $serializer;
        $this->redisConnection = $redisConnection;
    }

    /**
     * Получение пользователя по сессии
     * @param string $sessionKey
     *
     * @return \Entity\User|null
     * @throws \Exception
     */
    public function getBySession(string $sessionKey): ?User
    {
        return $this->serializer->normalize($this->redisConnection->getConnection()->get($this->getSessionKey($sessionKey)), User::class);
    }

    /**
     * Инициализация сессии
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function initSession(User $user): void
    {
        $this->redisConnection->getConnection()->set($this->getSessionKey($user->getId()), $this->serializer->jsonSignificant($user));
    }

    private function getSessionKey(string $key): string
    {
        return 'user_session_' . $key;
    }

    /**
     * Получение баланса подарков
     * @return mixed
     * @throws \Exception
     */
    public function getGiftInfo(): GiftBalanceInfo
    {
        return $this->serializer->normalize($this->redisConnection->getConnection()->get('gift_balance'), GiftBalanceInfo::class);
    }

    /**
     * Обновление баланса подарков
     * @param GiftBalanceInfo $info
     * @throws \Exception
     */
    public function updateGiftInfo(GiftBalanceInfo $info)
    {
        $this->redisConnection->getConnection()->set('gift_balance', $this->serializer->jsonSignificant($info));
    }
}