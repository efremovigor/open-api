<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:31
 */

namespace Middleware;


use Core\Service\Middleware\AbstractMiddleware;

class DebugMiddleware extends AbstractMiddleware
{
    public function getName(): string
    {
        return 'debug';
    }
}