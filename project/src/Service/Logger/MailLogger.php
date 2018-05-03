<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 27.04.18
 * Time: 15:14
 */

namespace Service\Logger;


use Psr\Log\AbstractLogger;

class MailLogger extends AbstractLogger
{

    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}