<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 13:14
 */

namespace Core\Service;

use Core\Request;
use Core\Response;
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
     * RequestHandler constructor.
     * @param MiddlewareSplQueue $middlewareSplQueue
     */
    public function __construct(MiddlewareSplQueue $middlewareSplQueue)
    {
        $this->request = new Request();
        $this->middlewares = $middlewareSplQueue;
    }

    /**
     * Handle the request and return a response.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->middlewares->shift()->process($this->request, $this);
    }

    public function process(): void
    {
        $this->response = $this->handle($this->request);
    }

}