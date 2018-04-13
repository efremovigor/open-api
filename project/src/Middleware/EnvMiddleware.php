<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:07
 */

namespace Middleware;


use Core\LoggingInterface;
use Core\Middleware\AbstractMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EnvMiddleware extends AbstractMiddleware implements LoggingInterface
{

    private $logs;
    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Exception
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $response = $handler->handle($request);
        echo "EnvMiddleware - init\r\n";
        return $response;
    }


    public function getName(): string
    {
        return 'env';
    }

    public function getLogs(): array
    {
        return $this->logs;
    }
}