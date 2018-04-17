<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 10:38
 */

namespace Core;

use Core\Container\ContainerItemInterface;
use Core\Container\Environment;
use Core\Container\Logger;
use Core\Container\Registry;
use Core\Container\Socket;

class ContainerRegistry extends AbstractRegistry
{

    /**
     * @return array
     */
    protected function getList(): array
    {
        return [
            Registry::ENV    => Environment::class,
            Registry::LOGGER => Logger::class,
            Registry::SOCKET => Socket::class,
        ];
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    protected function createInstance($id): ContainerItemInterface
    {
        $class = $this->getList()[$id];
        return new $class($this);
    }
}