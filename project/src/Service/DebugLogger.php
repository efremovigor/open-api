<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 27.04.18
 * Time: 15:15
 */

namespace Service;


use Psr\Log\AbstractLogger;

class DebugLogger extends AbstractLogger
{
    private $stack;

    public function log($level, $message, array $context = array())
    {
        $this->stack[] = [
            'level' => $level,
            'message' => $message,
        ];
    }

    public function getLog()
    {
        return $this->stack;
    }
}