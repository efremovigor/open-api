<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 10:38
 */

namespace Core\Container;


use Core\AbstractRegistry;

class ContainerRegistry extends AbstractRegistry
{
    public const CONTAINER = 'container';

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

    public function __construct(array $services)
    {
        $this->services = $services;
        self::$instances[self::CONTAINER] = $this;
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
}