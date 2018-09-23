<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:19
 */

namespace Entity;

use Service\ServiceConst;

/**
 * Подарок - предмет
 * Class ItemGift
 * @package Entity
 */
class ItemGift extends Gift implements GiftLimitedInterface
{
    public function getSender(): string
    {
        return ServiceConst::MAIL_GIFT_SENDER;
    }
}