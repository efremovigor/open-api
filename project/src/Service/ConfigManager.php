<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 11:59
 */

namespace Service;


use Core\App;
use Service\Entity\Conf\Base;
use Service\Entity\Conf\ExternalHostConf;
use Service\Socket\SocketRequest;

class ConfigManager
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
     * @var Base
     */
    private $conf;

    /**
     * @param Environment $environment
     * @param Socket $socket
     * @param YmlParser $ymlParser
     * @throws \Exception
     */
    public function __construct(Environment $environment, Socket $socket, YmlParser $ymlParser)
    {
        $this->env = $environment;
        $this->socket = $socket;
        $this->ymlParser = $ymlParser;
        $this->initConf();
    }


    public function get(): Base
    {
        return $this->conf;
    }


    /**
     * @throws \Exception
     */
    private function initConf(): void
    {
        if (!\file_exists($this->getParametersPath())) {
            $this->createFileParameters();
        }
        $this->conf = $this->ymlParser->packPath($this->getConfPath(), Base::class);
    }

    private function getParametersPath(): string
    {
        return App::getConfDir() . '/parameters.yml';
    }

    private function getConfPath(): string
    {
        return App::getConfDir() . '/conf.yml';
    }

    /**
     * @throws \Exception
     */
    private function createFileParameters(): void
    {
        /**
         * @var $conf ExternalHostConf
         */
        $conf = $this->ymlParser->packPath(App::getConfDir() . '/' . $this->env->get() . '/conf.yml', ExternalHostConf::class);
        $request = new SocketRequest($conf->getServer(), $conf->getUrl());
        $request->setTimeout(2);
        $parameters = $this->socket->call($request);
        if (empty($parameters->getBody())) {
            throw new \Exception('Invalid file parameters');
        }
        \file_put_contents($this->getParametersPath(), $parameters->getBody());
    }
}