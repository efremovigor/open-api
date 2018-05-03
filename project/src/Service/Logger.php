<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:37
 */

namespace Service;

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{
    /**
     * @var Environment
     */
    private $environment;


    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
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
    public function log($level, $message, array $context = array())
    {
        // TODO: Implement log() method.
    }
}