<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:24
 */

namespace Core\Container;


use Psr\Container\ContainerInterface;

abstract class AbstractContainerItem implements ContainerItemInterface
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}