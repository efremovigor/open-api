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
use Middleware\ControllerMiddleware;
use Middleware\DebugMiddleware;
use Middleware\InitMiddleware;
use Middleware\ProfilerMiddleware;
use Middleware\ResponseMiddleware;
use Middleware\RouterMiddleware;
use Middleware\TerminateMiddleware;
use Service\ServiceConst;

class Components implements ComponentsInterface
{

    public function getMiddlewares(): array
    {
        return [
            ProfilerMiddleware::class,
            InitMiddleware::class,
            DebugMiddleware::class,
            RouterMiddleware::class,
            ControllerMiddleware::class,
            ResponseMiddleware::class,
            TerminateMiddleware::class,
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
            ServiceConst::REPOSITORY => new ContainerItem(ServiceConst::REPOSITORY,[CoreServiceConst::CONTAINER]),
            ServiceConst::ORM_CONNECTION   => new ContainerItem(ServiceConst::ORM_CONNECTION, [CoreServiceConst::CONF_MANAGER]),
            ServiceConst::REDIS_CONNECTION => new ContainerItem(ServiceConst::REDIS_CONNECTION, [CoreServiceConst::CONF_MANAGER]),
        ];
    }
}