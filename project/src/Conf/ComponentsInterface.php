<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 03.05.18
 * Time: 15:21
 */

namespace Conf;


interface ComponentsInterface
{
    public function getMiddlewares(): array;
    public function getServices(): array;
}