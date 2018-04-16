<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 11:10
 */

namespace Core\Container;


use Psr\Container\ContainerInterface;

interface ContainerItemInterface
{
    public function __construct(ContainerInterface $container);
}