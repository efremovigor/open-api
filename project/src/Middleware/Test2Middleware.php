<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:07
 */

namespace Middleware;


use Core\Service\Middleware\AbstractMiddleware;

class Test2Middleware extends AbstractMiddleware
{
    public function getName(): string
    {
        return 'Test2';
    }
}