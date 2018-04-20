<?php

namespace Core;

use Psr\Container\ContainerInterface;

abstract class AbstractRegistry implements ContainerInterface
{

    /**
     * @var array
     */
    protected static $instances = [];

    /**
     * @return array|mixed
     */
    abstract protected function getList();

    /**
     * @param mixed $id
     * @return mixed
     */
    abstract protected function createInstance($id);

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