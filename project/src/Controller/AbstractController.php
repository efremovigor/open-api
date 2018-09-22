<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 18:17
 */

namespace Controller;


use Core\Container\ContainerServiceRegistry;
use Core\Service\CoreServiceConst;
use Core\Service\Serializer;
use Repository\RedisRepository;
use Repository\UserRepository;
use Service\ContainerRepositoryRegistry;
use Service\RepositoryConst;
use Service\ServiceConst;
use Service\Templater;

class AbstractController
{
    /**
     * @var ?string
     */
    protected $redirectRoute;

    /**
     * @var ContainerServiceRegistry
     */
    protected $container;

    public function __construct(ContainerServiceRegistry $container)
    {
        $this->container = $container;
    }

    /**
     * @return mixed
     */
    public function getRedirectRoute()
    {
        return $this->redirectRoute;
    }

    protected function getTempater(): Templater
    {
        return $this->container->get(ServiceConst::TEMPLATER);
    }

    protected function setRedirectRoute(string $route): void
    {
        $this->redirectRoute = $route;
    }

    protected function getSerializer(): Serializer
    {
        return $this->container->get(CoreServiceConst::SERIALIZER);
    }

    protected function getUserRepository(): UserRepository
    {
        return $this->getRepositoryRegistry()->get(RepositoryConst::USER);
    }


    protected function getRedisRepository(): RedisRepository
    {
        return $this->getRepositoryRegistry()->get(RepositoryConst::REDIS);
    }

    protected function getRepositoryRegistry(): ContainerRepositoryRegistry
    {
        return $this->container->get(ServiceConst::REPOSITORY);
    }
}