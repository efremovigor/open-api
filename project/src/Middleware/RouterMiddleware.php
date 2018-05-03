<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:06
 */

namespace Middleware;


use Core\Service\Middleware\AbstractMiddleware;
use Service\ServiceConst;

class RouterMiddleware extends AbstractMiddleware
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        echo "RouterMiddleware - init\r\n";
        var_dump($this->container->get(ServiceConst::ROUTER)->getPath());
    }

    public function getName(): string
    {
        return 'router';
    }
}