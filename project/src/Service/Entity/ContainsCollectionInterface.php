<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 25.04.18
 * Time: 14:48
 */

namespace Service\Entity;


interface ContainsCollectionInterface
{
    public function getClass(): string;

    public function set($key, $element): void;
}