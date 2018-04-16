<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 10:59
 */

namespace Core\Container;


class Environment extends AbstractContainerItem
{
    private $env;

    private const DEV = ['dev','test'];

    public function init(string $env): void
    {
        $this->env = $env;
    }

    /**
     * @return bool
     */
    public function isDev(): bool
    {
        return \in_array($this->env,self::DEV,true);
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
}