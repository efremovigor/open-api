<?php

namespace Core;

use Core\Container\ContainerItem;
use Core\Container\ContainerItemInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractRegistry implements ContainerInterface
{

    /**
     * @var array
     */
    protected static $instances = [];

	/**
	 * @var ContainerItem[]
	 */
	protected $services;

	/**
	 * @return array
	 */
	protected function getList(): array
	{
		return $this->services;
	}

    /**
     * @param mixed $id
     * @return mixed
     */
    protected function createInstance($id){
	    $containerItem = $this->getContainerItem($id);
	    $name = $containerItem->getClass();
	    return new $name(...$this->getInstanceArguments($containerItem));
    }

	/**
	 * @param string $key
	 * @return ContainerItemInterface
	 */
	private function getContainerItem(string $key): ContainerItemInterface
	{
		return $this->getList()[$key];
	}

	/**
	 * @param ContainerItemInterface $item
	 * @return array
	 */
	private function getInstanceArguments(ContainerItemInterface $item): array
	{
		$list = [];
		foreach ($item->getArguments() as $argument) {
			$list[] = $this->get($argument);
		}
		return $list;
	}

    /**
     * @param string $id
     * @return mixed
     */
    public function get($id)
    {
        if (array_key_exists($id, static::$instances)) {
            return static::$instances[$id];
        }

        if (!$this->has($id)) {
            return null;
        }

        static::$instances[$id] = $this->createInstance($id);

        return static::$instances[$id];
    }

    public function has($id): bool
    {
        return array_key_exists($id, $this->getList());
    }
}