<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 13.04.18
 * Time: 11:00
 */

namespace Core\Middleware;


use Core\MiddlewareLoggingInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * @var MiddlewareCollection
     */
    protected $middlewareCollection;

    public function __construct(MiddlewareCollection $middlewareCollection)
    {
        $this->middlewareCollection = $middlewareCollection;
        if($this instanceof MiddlewareLoggingInterface){
        }
    }
}