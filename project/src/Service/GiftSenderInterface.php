<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 14:29
 */

namespace Service;


use Entity\GiftInterface;

interface GiftSenderInterface
{
    public function sendGift(GiftInterface $gift);
}