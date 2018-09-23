<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:11
 */

namespace Entity;


use Service\GiftService;
use Service\ServiceConst;

/**
 * Подарок деньги
 * Class CashGift
 * @package Entity
 */
class CashGift extends Gift implements GiftLimitedInterface
{
    protected $cost;

    public function __construct()
    {
        $this->cost = rand(GiftService::MINIMAL_GIFT_CASH ,GiftService::MAX_GIFT_CASH);
    }

    public function getSender(): string
    {
        return ServiceConst::BANK_GIFT_SENDER;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost): void
    {
        $this->cost = $cost;
    }
}