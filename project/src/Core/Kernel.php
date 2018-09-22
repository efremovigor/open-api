<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 24.04.18
 * Time: 15:04
 */

namespace Core;


class Kernel
{
    /**
     * @return string
     */
    public static function getConfDir(): string
    {
        //todo think maybe better use path as parameter - self::getRootDir('/app/config') ??
        return self::getRootDir() . '/app/config';
    }

    /**
     * @return string
     */
    public static function getRootDir(): string
    {
        return __DIR__ . '/../..';
    }

    public static function getTemplateDir():string
    {
        return __DIR__ . '/../View/Template';
    }

    /**
     * @return string
     */
    public static function getCacheDir(): string
    {
        return self::getRootDir() . '/var/cache';
    }

    /**
     * @return string
     */
    public static function getLogDir(): string
    {
        return self::getRootDir() . '/var/logs';
    }
}