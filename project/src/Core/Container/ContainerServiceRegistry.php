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
use Core\Service\CoreServiceConst;

class ContainerServiceRegistry extends AbstractRegistry
{

    /**
     * @return array
     */
    private function getCoreServices(): array
    {
        return [
            CoreServiceConst::SERIALIZER => new ContainerItem(CoreServiceConst::SERIALIZER),
            CoreServiceConst::ENV => new ContainerItem(CoreServiceConst::ENV),
            CoreServiceConst::SOCKET => new ContainerItem(CoreServiceConst::SOCKET),
            CoreServiceConst::YML_PARSER => new ContainerItem(CoreServiceConst::YML_PARSER, [CoreServiceConst::SERIALIZER]),
            CoreServiceConst::CONF_MANAGER => new ContainerItem(
                CoreServiceConst::CONF_MANAGER,
                [CoreServiceConst::ENV, CoreServiceConst::SOCKET, CoreServiceConst::YML_PARSER]
            ),
            CoreServiceConst::REQUEST_HANDLER => new ContainerItem(CoreServiceConst::REQUEST_HANDLER,[CoreServiceConst::MIDDLEWARES]),
            CoreServiceConst::MIDDLEWARES => new ContainerItem(CoreServiceConst::MIDDLEWARES, [CoreServiceConst::CONTAINER,CoreServiceConst::CONF_MANAGER]),
        ];
    }

    public function __construct()
    {
        /**
         * Регистрируем самого себя в инстансах
         */
	    static::$instances[CoreServiceConst::CONTAINER] = $this;
        /**
         * Регистрируем сервисы ядра
         */
        $this->services = $this->getCoreServices();
        /**
         * Регистрируем остальные сервисы
         */
        $this->services = array_merge($this->services,$this->getConfigManager()->get()->getComponents()->getServices());
    }

    /**
     * @return ConfigManager
     */
    private function getConfigManager(): ConfigManager
    {
        return $this->get(CoreServiceConst::CONF_MANAGER);
    }
}