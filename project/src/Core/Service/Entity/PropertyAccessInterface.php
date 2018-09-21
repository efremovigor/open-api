<?php

namespace Core\Service\Entity;

/**
 * Предоставляет доступный список имен свойств
 * Interface PropertyAccessInterface
 * @package Helpers
 */
interface PropertyAccessInterface
{
    /**
     * @return array
     */
    public function getProperties(): array;
}