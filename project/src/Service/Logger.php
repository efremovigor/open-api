<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:37
 */

namespace Service;

use Core\Service\Environment;
use Core\Service\Serializer;
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Service\Logger\MailLogger;
use Service\Logger\StdErrLogger;

class Logger extends AbstractLogger
{
    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var LoggerInterface[]
     */
    private $loggers;

    /**
     * @var Serializer
     */
    private $serializer;


    public function __construct(Environment $environment, DebugLogger $debug, Serializer $serializer)
    {
        $this->environment = $environment;
        $this->serializer = $serializer;

        $this->loggers = [
            new StdErrLogger()
        ];

        if ($this->environment->isDev()) {
            $this->loggers[] = $debug;
            $this->loggers[] = new MailLogger();
        }
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
        if (\in_array($level, $this->environment->getLogLevel(), true)) {
            foreach ($this->loggers as $logger) {
                if (!\is_string($message)) {
                    $message = $this->serializer->normalize($message);
                }
                $logger->log($level, $message, $context);
            }
        }
    }
}