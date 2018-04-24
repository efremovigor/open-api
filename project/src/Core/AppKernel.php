<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 10:57
 */

namespace Core;

abstract class AppKernel extends Kernel
{

    /**
     * @var RequestHandler
     */
    private $requestHandler;

    /**
     * @var ContainerRegistry
     */
    private $container;

    /**
     * AppKernel constructor.
     */
    public function __construct()
    {
        $this->init();
    }

    public function run(): void
    {
        $this->requestHandler->process();
    }

    private function init(): void
    {
        $this->container = new ContainerRegistry($this->getServices());
        $this->requestHandler = new RequestHandler($this);
    }

    /**
     * @return ContainerRegistry
     */
    public function getContainer(): ContainerRegistry
    {
        return $this->container;
    }

    /**
     * @return array
     */
    abstract public function getMiddlewares(): array;

    /**
     * @return array
     */
    abstract public function getServices(): array;

}