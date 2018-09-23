<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:07
 */

namespace Service;


use Core\Container\ContainerServiceRegistry;
use Core\Service\CoreServiceConst;
use Core\Service\Serializer;
use Entity\CashGift;
use Entity\GiftInterface;
use Entity\GiftLimitedInterface;
use Entity\ItemGift;
use Entity\PointsGift;
use Entity\User;
use Repository\GiftRepository;
use Repository\RedisRepository;

/**
 * Class GiftService
 * @package Service
 */
class GiftService
{
    public const GIFT_POINTS = 'points';
    public const GIFT_ITEM   = 'item';
    public const GIFT_CASH   = 'cash';

    /**
     * минимальная сумма для кеш подарка
     */
    public const MINIMAL_GIFT_CASH = 300;

    /**
     *  максимальная сумма для кеш подарка
     */
    public const MAX_GIFT_CASH = 900;

    /**
     * безлимитный подарок
     */
    public const UNLIMITED = -1;

    /**
     * Коэфициент преобразования денег в очки
     */
    public const COEFFICIENT = 1.5;

    private static $senders = [
        AppGiftService::class,
        BankGiftService::class,
        GiftService::class,
    ];

    public static $gifts = [
        PointsGift::class,
        CashGift::class,
        ItemGift::class,
    ];

    /**
     * @var $container ContainerServiceRegistry
     */
    private $container;

    public function __construct(ContainerServiceRegistry $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $key
     * @return GiftSenderInterface
     */
    private function getSenders(string $key): GiftSenderInterface
    {
        return $this->container->get(static::$senders[$key]);
    }

    /**
     * @return RedisRepository
     */
    private function getRedisRepository(): RedisRepository
    {
        return $this->container->get(RepositoryConst::REDIS);
    }

    /**
     * @return GiftRepository
     */
    private function getGiftRepository(): GiftRepository
    {
        return $this->container->get(RepositoryConst::GIFT);
    }

    /**
     * @return Serializer
     */
    private function getSerializer(): Serializer
    {
        return $this->container->get(CoreServiceConst::SERIALIZER);
    }

    /**
     * Преобразует деньги в баллы
     * @param CashGift $cash
     * @throws \Exception
     */
    public function cashToPoints(CashGift $cash)
    {
        $points = $this->getSerializer()->normalize($cash, PointsGift::class);
        $points->setType(static::GIFT_POINTS);
        $points->setCost($points->getCost() * static::COEFFICIENT);
        $this->getGiftRepository()->save($points);
    }

    /**
     * Отказ от подарка
     * @param ItemGift $gift
     * @throws \Exception
     */
    public function refuseGift(ItemGift $gift)
    {
        $this->send($gift);
    }

    /**
     * @param GiftInterface $gift
     * @throws \Exception
     */
    public function send(GiftInterface $gift){
        $gift->setSend(true);
        $this->getGiftRepository()->save($gift);
    }

    /**
     * Выдача подарка
     * @throws \Exception
     */
    public function getGift(): ?GiftInterface
    {
        $info = $this->getRedisRepository()->getGiftInfo();
        $list = $info->getAccessGifts();
        if ($list > 0) {
            $key = $list[rand(0, count($list))];
            $gift = $this->createGift($key);
            if($gift instanceof GiftLimitedInterface){
                $info->updateBalance($gift);
                $this->getRedisRepository()->updateGiftInfo($info);
            }
            return $gift;
        }

        return null;
    }

    /**
     * Отправка подарка
     * @param User $user
     * @param GiftInterface $gift
     * @throws \Exception
     */
    public function sendGift(User $user, GiftInterface $gift): void
    {
        if ($user->getId() === $gift->getUserId()) {
            $this->getSenders($gift->getSender())->sendGift($gift);
            $this->send($gift);
        }
    }

    /**
     * Создание подарка
     * @param string $key
     * @return GiftInterface
     */
    public function createGift(string $key): GiftInterface
    {
        return new static::$gifts[$key]();
    }
}