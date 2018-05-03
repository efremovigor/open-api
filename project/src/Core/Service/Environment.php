<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 10:59
 */

namespace Core\Service;


use Conf\Env\Dev;
use Conf\Env\EnvConfInterface;
use Conf\Env\Prod;
use Conf\Env\Test;
use Psr\Log\LogLevel;

class Environment
{
    private $env;

    private const DEV = 'dev';
    private const PROD = 'prod';
    private const TEST = 'test';

    private const LOG_LEVELS = [
        self::DEV => [
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::NOTICE,
            LogLevel::INFO,
            LogLevel::DEBUG,
        ],
        self::PROD => [
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
        ],
        self::TEST => [
            LogLevel::EMERGENCY,
            LogLevel::ALERT,
            LogLevel::CRITICAL,
            LogLevel::ERROR,
            LogLevel::WARNING,
            LogLevel::NOTICE,
            LogLevel::INFO,
            LogLevel::DEBUG,
        ]
    ];

    public function set(string $env): void
    {
        $this->env = $env;
    }

    /**
     * @return bool
     */
    public function isDev(): bool
    {
        return \in_array($this->env, [static::DEV, static::TEST], true);
    }

    public function getLogLevel(): array
    {
        return self::LOG_LEVELS[$this->getMode()];
    }

    /**
     * Environment constructor.
     */
    public function __construct()
    {
        $this->set($_SERVER['ENV']);
    }

    public function getMode(): string
    {
        return $this->env;
    }

    /**
     * @return EnvConfInterface
     */
    public function getConf(): EnvConfInterface
    {
        switch ($this->env) {
            case static::DEV:
                return new Dev();
            case static::TEST:
                return new Test();
            case static::PROD:
                return new Prod();
        }
        throw new \RuntimeException('Invalid environment');
    }
}