<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 03.05.18
 * Time: 15:22
 */

namespace Conf;


use Core\Container\ContainerItem;
use Core\Service\CoreServiceConst;
use Service\ServiceConst;

class Components implements ComponentsInterface
{

    public function getMiddlewares(): array
    {
        return [
            \Middleware\ProfilerMiddleware::class,
            \Middleware\InitMiddleware::class,
            \Middleware\DebugMiddleware::class,
            \Middleware\RouterMiddleware::class,
            \Middleware\ControllerMiddleware::class,
            \Middleware\ResponseMiddleware::class,
            \Middleware\TerminateMiddleware::class,
        ];
    }

    public function getServices(): array
    {
        return [
            ServiceConst::DEBUG_LOGGER => new ContainerItem(ServiceConst::DEBUG_LOGGER),
            ServiceConst::LOGGER => new ContainerItem(ServiceConst::LOGGER, [CoreServiceConst::ENV, ServiceConst::DEBUG_LOGGER, CoreServiceConst::SERIALIZER]),
            ServiceConst::CACHE_MAN => new ContainerItem(ServiceConst::CACHE_MAN),
            ServiceConst::ROUTER => new ContainerItem(ServiceConst::ROUTER, [CoreServiceConst::YML_PARSER]),
            ServiceConst::PROFILER => new ContainerItem(ServiceConst::PROFILER),
        ];
    }
}