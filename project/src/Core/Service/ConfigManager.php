<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 11:59
 */

namespace Core\Service;


use Conf\Components;
use Conf\Env\ExternalHostConf;
use Conf\EnvConf;
use Core\App;
use Core\Service\Socket\SocketRequest;

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
     * @var  \Conf\Conf
     */
    private $conf;

    /**
     * Вид работы сервиса, когда он тянет конфиг из предопределенных классов
     */
    private const SELF_MODE = 'self';

    /**
     * Вид работы сервиса, когда пытается подтянуть конфиг на основе данных откуда их брать
     */
    private const EXTERNAL_MODE = 'external';

    /**
     * Вид работы(выставляется ручками)
     */
    private const MODE = self::SELF_MODE;

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
        $this->conf = new \Conf\Conf();

        $this->init();
    }


    public function get():  \Conf\Conf
    {
        return $this->conf;
    }


    /**
     * @throws \Exception
     */
    private function init(): void
    {
        switch (self::MODE) {
            case self::EXTERNAL_MODE:
                if (!\file_exists($this->getParametersPath())) {
                    $this->createFileParameters();
                }
                $this->conf->setEnvConf($this->ymlParser->packPath($this->getConfPath(), EnvConf::class));
                break;
            case self::SELF_MODE:
                $this->conf->setEnvConf($this->env->getConf());
                break;
        }
        $this->conf->setComponents(new Components());

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
        $conf = $this->ymlParser->packPath(App::getConfDir() . '/' . $this->env->getMode() . '/conf.yml', ExternalHostConf::class);
        $request = new SocketRequest($conf->getServer(), $conf->getUrl());
        $request->setTimeout(2);
        $parameters = $this->socket->call($request);
        if (empty($parameters->getBody())) {
            throw new \Exception('Invalid file parameters');
        }
        \file_put_contents($this->getParametersPath(), $parameters->getBody());
    }
}