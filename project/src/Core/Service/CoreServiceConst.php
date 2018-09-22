<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:46
 */

namespace Core\Service;

use Core\Container\ContainerServiceRegistry;

final class CoreServiceConst
{
    public const ENV = Environment::class;
    public const SOCKET = Socket::class;
    public const YML_PARSER = YmlParser::class;
    public const CONF_MANAGER = ConfigManager::class;
    public const SERIALIZER = Serializer::class;
    public const REQUEST_HANDLER = RequestHandler::class;
    public const MIDDLEWARES = MiddlewareSplQueue::class;
    public const CONTAINER = ContainerServiceRegistry::class;
}