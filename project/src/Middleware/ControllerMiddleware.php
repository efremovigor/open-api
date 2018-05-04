<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:09
 */

namespace Middleware;

use Core\Service\Middleware\AbstractMiddleware;

class ControllerMiddleware extends AbstractMiddleware
{

    public function getName(): string
    {
        return 'controller';
    }
}