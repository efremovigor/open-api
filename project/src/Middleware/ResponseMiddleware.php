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

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        echo "ResponseMiddleware - init\r\n";
    }

    public function getName(): string
    {
        return 'response';
    }
}