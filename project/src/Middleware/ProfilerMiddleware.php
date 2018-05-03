<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:40
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;
use Service\ConfigManager;
use Service\Profiler\ProfilerInterface;
use Service\ServiceConst;

class ProfilerMiddleware extends AbstractMiddleware
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function before(): void
    {
        echo "ProfilerMiddleware - init\r\n";
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
            var_dump($this->getProfiler()->info());
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
        return $this->container->get(ServiceConst::CONF_MANAGER);
    }
}