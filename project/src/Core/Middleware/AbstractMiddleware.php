<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 13.04.18
 * Time: 11:00
 */

namespace Core\Middleware;


use Psr\Container\ContainerInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * @var MiddlewareSplQueue
     */
    protected $middlewareCollection;
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * AbstractMiddleware constructor.
     * @param MiddlewareSplQueue $middlewareCollection
     * @param ContainerInterface $container
     */
    public function __construct(MiddlewareSplQueue $middlewareCollection, ContainerInterface $container)
    {
        $this->middlewareCollection = $middlewareCollection;
        $this->container = $container;
    }
}