<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 11:59
 */

namespace Core\Container;


class ConfigManager extends AbstractContainerItem
{

    /**
     * @var Environment
     */
    private $env;

    /**
     * @var Socket
     */
    private $socket;

    /**
     * @var YmlParser
     */
    private $ymlParser;

    public function init(): void
    {
        $this->env = $this->container->get(Registry::ENV);
        $this->socket = $this->container->get(Registry::SOCKET);
        $this->ymlParser = $this->container->get(Registry::YML_PARSER);
    }

    public function get()
    {
        return $this->ymlParser->getYml(\Core\App::getConfDir().'/'.$this->env->get().'/conf.yml');
    }
}