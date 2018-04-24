<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:40
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;

class ProfilerMiddleware extends AbstractMiddleware
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        echo "ProfilerMiddleware - init\r\n";
    }

    public function getName(): string
    {
        return 'profiler';
    }
}