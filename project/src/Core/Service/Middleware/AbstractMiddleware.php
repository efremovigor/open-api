<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 13.04.18
 * Time: 11:00
 */

namespace Core\Service\Middleware;


use Core\Response;
use Core\Service\MiddlewareSplQueue;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LogLevel;
use Service\Logger;
use Service\ServiceConst;

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
     * @var Logger
     */
    private $logger;

	/**
	 * AbstractMiddleware constructor.
	 *
	 * @param MiddlewareSplQueue $middlewareCollection
	 * @param ContainerInterface $container
	 *
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 */
    public function __construct(MiddlewareSplQueue $middlewareCollection, ContainerInterface $container)
    {
        $this->middlewareCollection = $middlewareCollection;
        $this->container = $container;
        $this->logger = $this->container->get(ServiceConst::LOGGER);
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
            $this->logger->log(LogLevel::INFO, \get_class($this).' - init');
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

    /**
     * @return Logger
     */
    protected function getLogger(): Logger
    {
        return $this->logger;
    }

}