<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 03.05.18
 * Time: 15:22
 */

namespace Conf;


use Core\Container\ContainerItem;
use Service\Cache;
use Service\Logger;
use Service\Router;
use Service\ServiceConst;
use Service\XhprofProfiler;

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
            ServiceConst::LOGGER => new ContainerItem(Logger::class),
            ServiceConst::CACHE_MAN => new ContainerItem(Cache::class),
            ServiceConst::ROUTER => new ContainerItem(Router::class, [ServiceConst::YML_PARSER]),
            ServiceConst::PROFILER => new ContainerItem(XhprofProfiler::class),
        ];
    }
}