<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:24
 */

namespace Middleware;


use Core\Middleware\AbstractMiddleware;
use Core\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class TryMiddleware extends AbstractMiddleware
{
    public const NAME = 'exception';

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        echo "TryMiddleware - init\r\n";
        try {
            return $handler->handle($request);
        }catch (\Exception $exception){
            var_dump($exception->getMessage());
            return new Response();
        }
    }

    public function getName(): string
    {
        return 'exception';
    }
}