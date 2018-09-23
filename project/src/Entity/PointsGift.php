<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:19
 */

namespace Entity;


use Service\GiftService;
use Service\ServiceConst;

/**
 * Подарок очки лояльности
 * Class PointsGift
 * @package Entity
 */
class PointsGift extends Gift
{
    protected $cost;

    public function __construct()
    {
        $this->cost = rand(GiftService::MINIMAL_GIFT_CASH ,GiftService::MAX_GIFT_CASH);
    }

    public function getSender(): string
    {
        return ServiceConst::APP_GIFT_SENDER;
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