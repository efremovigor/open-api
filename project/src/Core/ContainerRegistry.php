<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 10:38
 */

namespace Core;

use Core\Container\Cache;
use Core\Container\ConfigManager;
use Core\Container\ContainerItem;
use Core\Container\ContainerItemInterface;
use Core\Container\Environment;
use Core\Container\Logger;
use Core\Container\ServiceConst;
use Core\Container\Serializer;
use Core\Container\Socket;
use Core\Container\YmlParser;

class ContainerRegistry extends AbstractRegistry
{

    /**
     * @return array
     */
    protected function getList(): array
    {
        return [
            ServiceConst::ENV          => new ContainerItem(Environment::class),
            ServiceConst::LOGGER       => new ContainerItem(Logger::class),
            ServiceConst::SOCKET       => new ContainerItem(Socket::class),
            ServiceConst::YML_PARSER   => new ContainerItem(YmlParser::class, [ServiceConst::SERIALIZER]),
            ServiceConst::CONF_MANAGER => new ContainerItem(
                ConfigManager::class,
                [ServiceConst::ENV, ServiceConst::SOCKET, ServiceConst::YML_PARSER]
            ),
            ServiceConst::SERIALIZER   => new ContainerItem(Serializer::class),
            ServiceConst::CACHE_MAN    => new ContainerItem(Cache::class),
        ];
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    protected function createInstance($id)
    {
        $containerItem = $this->getContainerItem($id);
        $name = $containerItem->getClass();
        return new $name(...$this->getInstanceArguments($containerItem));
    }

    private function getContainerItem(string $key): ContainerItemInterface
    {
        return $this->getList()[$key];
    }

    private function getInstanceArguments(ContainerItemInterface $item):array {
        $list = [];
        foreach($item->getArguments() as $argument) {
            $list[] = $this->get($argument);
        }
        return $list;
    }
}