<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:31
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;

class DebugMiddleware extends AbstractMiddleware
{


    protected function before(): void
    {
        echo "DebugMiddleware - init\r\n";
    }


    public function getName(): string
    {
        return 'debug';
    }
}