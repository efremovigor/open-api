<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 10:38
 */

namespace Core\Container;


use Core\AbstractRegistry;
use Core\Service\ConfigManager;
use Core\Service\Environment;
use Core\Service\MiddlewareSplQueue;
use Core\Service\RequestHandler;
use Core\Service\Serializer;
use Core\Service\CoreServiceConst;
use Core\Service\Socket;
use Core\Service\YmlParser;

class ContainerRegistry extends AbstractRegistry
{
    public const CONTAINER = 'container';

    private function getCoreServices()
    {
        return [
            CoreServiceConst::SERIALIZER => new ContainerItem(Serializer::class),
            CoreServiceConst::ENV => new ContainerItem(Environment::class),
            CoreServiceConst::SOCKET => new ContainerItem(Socket::class),
            CoreServiceConst::YML_PARSER => new ContainerItem(YmlParser::class, [CoreServiceConst::SERIALIZER]),
            CoreServiceConst::CONF_MANAGER => new ContainerItem(
                ConfigManager::class,
                [CoreServiceConst::ENV, CoreServiceConst::SOCKET, CoreServiceConst::YML_PARSER]
            ),
            CoreServiceConst::REQUEST_HANDLER => new ContainerItem(RequestHandler::class,[CoreServiceConst::MIDDLEWARES]),
            CoreServiceConst::MIDDLEWARES => new ContainerItem(MiddlewareSplQueue::class, [self::CONTAINER,CoreServiceConst::CONF_MANAGER]),
        ];
    }

    /**
     * @var ContainerItem[]
     */
    private $services;

    /**
     * @return array
     */
    protected function getList(): array
    {
        return $this->services;
    }

    public function __construct()
    {
        self::$instances[self::CONTAINER] = $this;
        $this->services = $this->getCoreServices();
        $this->services = array_merge($this->services,$this->getConfigManager()->get()->getComponents()->getServices());
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

    private function getInstanceArguments(ContainerItemInterface $item): array
    {
        $list = [];
        foreach ($item->getArguments() as $argument) {
            $list[] = $this->get($argument);
        }
        return $list;
    }

    /**
     * @return ConfigManager
     */
    private function getConfigManager(): ConfigManager
    {
        return $this->get(CoreServiceConst::CONF_MANAGER);
    }
}