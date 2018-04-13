<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 10:59
 */

namespace Core;


class Environment
{
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

    public function getName(): string
    {

    }
}