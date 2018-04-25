<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:30
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;
use Core\Response;

class TerminateMiddleware extends AbstractMiddleware
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        echo "TerminateMiddleware - init\r\n";
    }

    public function getName(): string
    {
        return 'terminate';
    }
}