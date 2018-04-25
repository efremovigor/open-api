<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 10:59
 */

namespace Service;


class Environment
{
    private $env;

    private const DEV = ['dev', 'test'];

    public function set(string $env): void
    {
        $this->env = $env;
    }

    /**
     * @return bool
     */
    public function isDev(): bool
    {
        return \in_array($this->env, self::DEV, true);
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

    public function get(): string
    {
        return $this->env;
    }
}