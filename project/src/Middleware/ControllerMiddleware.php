<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:09
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;

class ControllerMiddleware extends AbstractMiddleware
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @return void
     */

    protected function before():void
    {
        echo "ControllerMiddleware - init \r\n ";
    }

    public function getName(): string
    {
        return 'controller';
    }
}