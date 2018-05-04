<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:30
 */

namespace Middleware;


use Core\Service\Middleware\AbstractMiddleware;

class TerminateMiddleware extends AbstractMiddleware
{
    public function getName(): string
    {
        return 'terminate';
    }
}