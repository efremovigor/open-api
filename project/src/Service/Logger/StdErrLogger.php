<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 04.05.18
 * Time: 8:52
 */

namespace Service\Logger;


use Psr\Log\AbstractLogger;

class StdErrLogger extends AbstractLogger
{

    private $stream;

    public function __construct()
    {
        $this->stream = fopen('php://stderr', 'wb');
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     *
     * @return void
     */
    public function log($level, $message, array $context = array()): void
    {
        fwrite($this->stream, 'level:' . $level . ';msg:' . json_encode($message));
    }
}