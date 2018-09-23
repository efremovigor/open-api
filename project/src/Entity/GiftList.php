<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 15:27
 */

namespace Entity;


use Core\AbstractCollection;
use Service\GiftService;

/**
 * Лист подарков
 * Class GiftList
 * @package Entity
 */
class GiftList extends AbstractCollection
{
    private $points;
    private $cash;
    private $item;

    public function getPoints(){
        if($this->points === null) {
            $this->points = array_filter(
                $this->elements,
                function(GiftInterface $gift)
                {
                    return $gift->getType() === GiftService::GIFT_POINTS;
                }
            );
        }
        return $this->points;
    }

    public function getCash(){
        if($this->cash === null) {
            $this->cash = array_filter(
                $this->elements,
                function(GiftInterface $gift)
                {
                    return $gift->getType() === GiftService::GIFT_CASH;
                }
            );
        }
        return $this->cash;
    }

    public function getItem(){
        if($this->item === null) {
            $this->item = array_filter(
                $this->elements,
                function(GiftInterface $gift)
                {
                    return $gift->getType() === GiftService::GIFT_ITEM;
                }
            );
        }
        return $this->item;
    }
}