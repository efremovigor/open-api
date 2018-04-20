<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 11:10
 */

namespace Core\Container;

interface ContainerItemInterface
{
    public function getClass():string ;

    public function getArguments():array;
}