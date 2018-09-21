<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 25.04.18
 * Time: 14:48
 */

namespace Core\Service\Entity;


/**
 * Поведение класса содержащий коллекцию классов одного типа
 *
 * Interface ContainsCollectionInterface
 * @package Helpers
 */
interface ContainsCollectionInterface
{
    /**
     * Имя класса списка
     * @return string
     */
    public function getClass(): string;

    /**
     * Сохранение элемента списка
     * @param $key
     * @param $element
     */
    public function set($key, $element): void;

    /**
     * Получение элементов списка
     * @return array
     */
    public function getElements(): array;
}