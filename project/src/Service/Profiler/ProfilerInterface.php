<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 03.05.18
 * Time: 12:43
 */

namespace Service\Profiler;


interface ProfilerInterface
{
    public function start(): void;

    public function end(): void;

    /**
     * @return mixed
     */
    public function info();
}