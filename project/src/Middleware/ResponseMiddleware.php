<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:28
 */

namespace Middleware;


use Core\Service\Middleware\AbstractMiddleware;

class ResponseMiddleware extends AbstractMiddleware
{
    public function getName(): string
    {
        return 'response';
    }
}