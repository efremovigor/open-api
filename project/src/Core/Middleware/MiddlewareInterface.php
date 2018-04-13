<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 15:56
 */

namespace Core\Middleware;


interface MiddlewareInterface extends \Psr\Http\Server\MiddlewareInterface
{
    public function getName(): string;
}