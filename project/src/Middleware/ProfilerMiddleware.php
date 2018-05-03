<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:40
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;
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
        $this->getProfiler()->start();
    }

    protected function after(): void
    {
        $this->getProfiler()->end();
    }

    public function getName(): string
    {
        return 'profiler';
    }

    /**
     * @return ProfilerInterface
     */
    public function getProfiler(): ProfilerInterface
    {
        return $this->container->get(ServiceConst::PROFILER);

    }
}