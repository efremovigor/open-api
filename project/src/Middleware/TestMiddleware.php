<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:07
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;

class TestMiddleware extends AbstractMiddleware
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        echo "TestMiddleware - init\r\n";
    }


    public function getName(): string
    {
        return 'env';
    }
}