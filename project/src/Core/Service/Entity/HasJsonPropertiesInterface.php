<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 18.10.18
 * Time: 15:06
 */

namespace Core\Service\Entity;


interface HasJsonPropertiesInterface
{
    public function getJsonProperties(): array;
}