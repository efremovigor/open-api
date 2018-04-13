<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 13.04.18
 * Time: 15:36
 */

namespace Core;


interface MiddlewareLoggingInterface extends LoggingInterface
{

    public function add(Request $request): void;
}