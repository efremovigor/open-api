<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 13:14
 */

namespace Core;

use Core\Middleware\MiddlewareSplQueue;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RequestHandler implements RequestHandlerInterface
{
    /**
     * @var MiddlewareSplQueue
     */
    private $middlewares;

    /**
     * @var Request $request
     */
    private $request;

    /**
     * @var Response $response
     */
    private $response;

    /**
     * @return MiddlewareInterface[]
     */
    public function registerMiddlewares(): array
    {
        return [
            \Middleware\TryMiddleware::class,
            \Middleware\ProfilerMiddleware::class,
            \Middleware\EnvMiddleware::class,
            \Middleware\InitMiddleware::class,
            \Middleware\DebugMiddleware::class,
            \Middleware\RouterMiddleware::class,
            \Middleware\ControllerMiddleware::class,
            \Middleware\ResponseMiddleware::class,
            \Middleware\TerminateMiddleware::class,
        ];
    }

    public function __construct()
    {
        $this->request = new Request();
        $this->middlewares = new MiddlewareSplQueue($this->registerMiddlewares(),new ContainerRegistry());
    }

    /**
     * Handle the request and return a response.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware =$this->middlewares->shift();
        if ($middleware !== null) {
            $this->response = $middleware->process($this->request, $this);
        }
        return $this->response;
    }

    public function process(): void
    {
        $this->response = $this->handle($this->request);
    }

}