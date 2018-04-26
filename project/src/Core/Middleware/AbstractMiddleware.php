<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 13.04.18
 * Time: 11:00
 */

namespace Core\Middleware;


use Core\Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    /**
     * @var MiddlewareSplQueue
     */
    protected $middlewareCollection;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var RequestHandlerInterface
     */
    protected $handler;

    /**
     * @var ResponseInterface|Response
     */
    protected $response;

    /**
     * AbstractMiddleware constructor.
     * @param MiddlewareSplQueue $middlewareCollection
     * @param ContainerInterface $container
     */
    public function __construct(MiddlewareSplQueue $middlewareCollection, ContainerInterface $container)
    {
        $this->middlewareCollection = $middlewareCollection;
        $this->container = $container;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $this->request = $request;
        $this->handler = $handler;
        if ($this->response === null) {
            $this->response = new Response();
        }

        try {
            $this->before();
            $this->pushResponseNext();
            if (!$this->middlewareCollection->isEmpty()) {
                $this->response = $handler->handle($this->request);
            }
            $this->after();
        } catch (\Exception $exception) {
            $exception->getMessage();
        }

        return $this->response;
    }

    private function pushResponseNext(): void
    {
        $this->middlewareCollection->rewind();
        $nextMiddleware = $this->middlewareCollection->current();
        if ($nextMiddleware !== null) {
            $nextMiddleware->setResponse($this->response);
        }
    }

    public function setResponse(ResponseInterface $response): void
    {
        $this->response = $response;
    }

    protected function before(): void
    {
    }

    protected function after(): void
    {
    }

}