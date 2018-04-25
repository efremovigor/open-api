<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 13:14
 */

namespace Core;

use Core\Middleware\MiddlewareSplQueue;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Service\ServiceConst;

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

    public function __construct(AppKernel $app)
    {
        $this->request = new Request();

        /**
         * @var MiddlewareSplQueue
         */
        $this->middlewares = $app->getContainer()->get(ServiceConst::MIDDLEWARES);
        $this->middlewares->pushList($app->getMiddlewares());
    }

    /**
     * Handle the request and return a response.
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $middleware = $this->middlewares->shift();
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