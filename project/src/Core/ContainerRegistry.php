<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 10:38
 */

namespace Core;

use Core\Container\ConfigManager;
use Core\Container\ContainerItemInterface;
use Core\Container\Environment;
use Core\Container\Logger;
use Core\Container\Registry;
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
            Registry::ENV          => Environment::class,
            Registry::LOGGER       => Logger::class,
            Registry::SOCKET       => Socket::class,
            Registry::YML_PARSER   => YmlParser::class,
            Registry::CONF_MANAGER => ConfigManager::class,
            Registry::SERIALIZER   => Serializer::class,
        ];
    }

    public function get($id): ContainerItemInterface
    {
        return parent::get($id);
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    protected function createInstance($id): ContainerItemInterface
    {
        $class = $this->getList()[$id];
        /**
         * @var $init ContainerItemInterface
         */
        $init = new $class($this);
        $init->init();
        return $init;
    }
}