<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 13.04.18
 * Time: 16:09
 */

namespace Core;


use Core\Middleware\MiddlewareInterface;

class MiddlewareLogStack
{

    private $middleware;

    private $stack;

    public function __construct(MiddlewareInterface $middleware)
    {
        $this->middleware = $middleware->getName();
    }

    public function getMiddleware():string
    {
        return $this->middleware;
    }

    public function add(LogItem $item): void
    {
        $this->stack[] = $item;
    }

}