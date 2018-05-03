<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:11
 */

namespace Middleware;


use Core\Service\Middleware\AbstractMiddleware;
use Service\ServiceConst;

class InitMiddleware extends AbstractMiddleware
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        echo "InitMiddleware - init\r\n";
        $this->initConf();
        $this->container->get(ServiceConst::CACHE_MAN)->getRedis();
    }

    public function getName(): string
    {
        return 'init';
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function initConf(): void
    {

        var_dump($this->container->get(ServiceConst::CONF_MANAGER)->get());
    }

}