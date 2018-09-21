<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 11.09.18
 * Time: 8:20
 */

namespace Core\Service\Entity;

/**
 * Поведение, что сущность может предоставить ключ как себя хранить в списке
 * Interface CollectionKeyInterface
 * @package Helpers
 */
interface CollectionKeyInterface
{
    /**
     * Метод возвращающий ключ сущности
     * @return string
     */
    public function getCollectionKey():string;
}