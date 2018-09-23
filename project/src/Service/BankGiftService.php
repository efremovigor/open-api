<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:27
 */

namespace Service;


use Entity\GiftInterface;

class BankGiftService implements GiftSenderInterface
{

    /**
     * Отправка денег через банк
     * @param GiftInterface $gift
     */
    public function sendGift(GiftInterface $gift)
    {
        /**
         * Send via bank
         */
    }
}