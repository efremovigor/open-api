<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 10:59
 */

namespace Service;


use Conf\Dev;
use Conf\EnvConfInterface;
use Conf\Prod;
use Conf\Test;

class Environment
{
    private $env;

    private const DEV = 'dev';
    private const PROD = 'prod';
    private const TEST = 'test';

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
        return [
            'emergency',
            'alert',
            'critical',
            'error',
            'warning',
            'notice',
            'info',
            'debug',
        ];
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