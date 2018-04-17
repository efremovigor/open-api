<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 11:59
 */

namespace Core\Container;


use Core\App;

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

    /**
     * @var ExternalConf
     */
    private $conf;

    /**
     * @throws \Exception
     */
    public function init(): void
    {
        //todo tothink - implicit common method use - probably we should retur object of specified class??
        // i. e. $this->env = $this->container->getEnvironment();
        $this->env = $this->container->get(Registry::ENV);
        $this->socket = $this->container->get(Registry::SOCKET);
        $this->ymlParser = $this->container->get(Registry::YML_PARSER);
        $this->initConf();
    }


    public function get(): ExternalConf
    {
       return $this->conf;
    }


    /**
     * @throws \Exception
     */
    private function initConf(): void
    {
        if(!\file_exists($this->getParametersPath())){
            $this->createFileParameters();
        }
        $this->conf = $this->ymlParser->packPath($this->getParametersPath(),ExternalConf::class);
    }

    private function getParametersPath(): string
    {
        return App::getConfDir() . '/parameters.yml';
    }

    /**
     * @throws \Exception
     */
    private function createFileParameters():void{
        /**
         * @var $conf ExternalHostConf
         */
        $conf = $this->ymlParser->packPath(App::getConfDir() . '/' . $this->env->get() . '/conf.yml', ExternalHostConf::class);
        $request = new SocketRequest($conf->getServer(), $conf->getUrl());
        $request->setTimeout(2);
        $parameters = $this->socket->call($request);
        \file_put_contents($this->getParametersPath(), $parameters->getBody());
    }
}