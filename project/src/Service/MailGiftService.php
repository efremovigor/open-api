<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:28
 */

namespace Service;


use Entity\GiftInterface;

class MailGiftService implements GiftSenderInterface
{

    /**
     * Отправка по почте
     * @param GiftInterface $gift
     */
    public function sendGift(GiftInterface $gift)
    {
        /**
         * Send via mail
         */
    }
}