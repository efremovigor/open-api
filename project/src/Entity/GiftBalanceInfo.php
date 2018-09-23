<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 15:54
 */

namespace Entity;


use Core\Service\Entity\PropertyAccessInterface;
use Service\GiftService;

class GiftBalanceInfo implements PropertyAccessInterface
{
    protected $balanceCash;
    protected $balanceItem;
    protected $balancePoints;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'balanceCash',
            'balanceItem',
            'balancePoints',
        ];
    }

    /**
     * @return mixed
     */
    public function getBalanceCash()
    {
        return $this->balanceCash;
    }

    /**
     * @param mixed $balanceCash
     */
    public function setBalanceCash($balanceCash): void
    {
        $this->balanceCash = $balanceCash;
    }

    /**
     * @return mixed
     */
    public function getBalanceItem()
    {
        return $this->balanceItem;
    }

    /**
     * @param mixed $balanceItem
     */
    public function setBalanceItem($balanceItem): void
    {
        $this->balanceItem = $balanceItem;
    }

    /**
     * @return mixed
     */
    public function getBalancePoints()
    {
        return $this->balancePoints;
    }

    /**
     * @param mixed $balancePoints
     */
    public function setBalancePoints($balancePoints): void
    {
        $this->balancePoints = $balancePoints;
    }

    /**
     * Получение доступных подарков
     * @return array
     */
    public function getAccessGifts(): array
    {
        $list = GiftService::$gifts;
        if ($this->balanceCash < GiftService::MINIMAL_GIFT_CASH && $this->balanceCash != GiftService::UNLIMITED) {
            unset($list[CashGift::class]);
        }
        if ($this->balanceItem === 0 && $this->balanceItem != GiftService::UNLIMITED) {
            unset($list[ItemGift::class]);
        }

        return $list;
    }

    /**
     * Обновление Общей инфы о подарках
     * @param GiftLimitedInterface $gift
     */
    public function updateBalance(GiftLimitedInterface $gift): void
    {
        switch (true) {
            case $gift instanceOf ItemGift:
                --$this->balanceItem;
                break;
            case $gift instanceOf CashGift:
                $this->setBalanceCash($this->getBalanceCash() - $gift->getCost());
                break;
        }
    }
}