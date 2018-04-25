<?php

namespace Core;

use Core\Container\ContainerItem;
use Core\Container\ContainerRegistry;
use Core\Middleware\MiddlewareSplQueue;
use Service\Cache;
use Service\ConfigManager;
use Service\Environment;
use Service\Logger;
use Service\Router;
use Service\Serializer;
use Service\ServiceConst;
use Service\Socket;
use Service\YmlParser;

class App extends AppKernel
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
            ServiceConst::ENV => new ContainerItem(Environment::class),
            ServiceConst::LOGGER => new ContainerItem(Logger::class),
            ServiceConst::SOCKET => new ContainerItem(Socket::class),
            ServiceConst::YML_PARSER => new ContainerItem(YmlParser::class, [ServiceConst::SERIALIZER]),
            ServiceConst::CONF_MANAGER => new ContainerItem(
                ConfigManager::class,
                [ServiceConst::ENV, ServiceConst::SOCKET, ServiceConst::YML_PARSER]
            ),
            ServiceConst::SERIALIZER => new ContainerItem(Serializer::class),
            ServiceConst::CACHE_MAN => new ContainerItem(Cache::class),
            ServiceConst::MIDDLEWARES => new ContainerItem(MiddlewareSplQueue::class, [ContainerRegistry::CONTAINER]),
            ServiceConst::ROUTER => new ContainerItem(Router::class, [ServiceConst::YML_PARSER])
        ];
    }
}
