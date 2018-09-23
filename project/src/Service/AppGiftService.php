<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:27
 */

namespace Service;


use Entity\GiftInterface;

/**
 * Class AppGiftService
 * @package Service
 */
class AppGiftService implements GiftSenderInterface
{

    /**
     * Отправка баллы в приложение
     * @param GiftInterface $gift
     */
    public function sendGift(GiftInterface $gift)
    {
        /**
         * Send gift to app
         */
    }
}