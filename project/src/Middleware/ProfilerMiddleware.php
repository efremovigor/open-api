<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:40
 */

namespace Middleware;


use Core\Service\ConfigManager;
use Core\Service\CoreServiceConst;
use Core\Service\Middleware\AbstractMiddleware;
use Psr\Log\LogLevel;
use Service\Profiler\ProfilerInterface;
use Service\ServiceConst;

class ProfilerMiddleware extends AbstractMiddleware
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        if($this->getConf()->get()->getEnvConf()->isProfiling()){
            $this->getProfiler()->start();
        }
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function after(): void
    {
        if($this->getConf()->get()->getEnvConf()->isProfiling()){
            $this->getProfiler()->end();
            $this->getLogger()->log(LogLevel::INFO,$this->getProfiler()->info());
            var_dump($this->container->get(ServiceConst::DEBUG_LOGGER)->getLog());
        }
    }

    public function getName(): string
    {
        return 'profiler';
    }

    /**
     * @return ProfilerInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function getProfiler(): ProfilerInterface
    {
        return $this->container->get(ServiceConst::PROFILER);
    }

    /**
     * @return ConfigManager
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function getConf(): ConfigManager
    {
        return $this->container->get(CoreServiceConst::CONF_MANAGER);
    }
}