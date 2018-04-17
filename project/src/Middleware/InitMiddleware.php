<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:11
 */

namespace Middleware;


use Core\Container\Registry;
use Core\Container\SocketRequest;
use Core\Container\SocketResponse;
use Core\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class InitMiddleware extends AbstractMiddleware
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        echo "InitMiddleware - init\r\n";

        /**
         * @var $socketResponse SocketResponse
         */
        $socketResponse = $this->container->get(Registry::SOCKET)->call(new SocketRequest('gardenmoto.ru','/robots.txt'));

        return $handler->handle($request);
    }

    public function getName(): string
    {
        return 'init';
    }

}