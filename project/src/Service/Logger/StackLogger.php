<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 27.04.18
 * Time: 15:15
 */

namespace Service\Logger;


use Psr\Log\AbstractLogger;

class StackLogger extends AbstractLogger
{

    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}