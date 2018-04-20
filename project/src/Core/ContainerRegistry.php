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
            ServiceConst::ENV          => Environment::class,
            ServiceConst::LOGGER       => Logger::class,
            ServiceConst::SOCKET       => Socket::class,
            ServiceConst::YML_PARSER   => YmlParser::class,
            ServiceConst::CONF_MANAGER => ConfigManager::class,
            ServiceConst::SERIALIZER   => Serializer::class,
            ServiceConst::CACHE_MAN    => Cache::class,
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