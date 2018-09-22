<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:09
 */

namespace Middleware;

use Controller\AbstractController;
use Core\Service\Middleware\AbstractMiddleware;
use Service\Router;
use Service\ServiceConst;

class ControllerMiddleware extends AbstractMiddleware
{

    public function getName(): string
    {
        return 'controller';
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Exception
     */
    public function before(): void
    {
        $controller = $this->getRouter()->currentPath()->getController();
        $action = $this->getRouter()->currentPath()->getAction();
        /**
         * @var $controller AbstractController
         */
        $controller = new $controller($this->container);
        $this->setResponse($controller->$action());
        if($controller->getRedirectRoute() !== null){
            header('HTTP/1.1 301 OK');
            header('Location: http://'.$_SERVER['HTTP_HOST'].$this->getRouter()->getPath($controller->getRedirectRoute())->getRoute());
            /**
             * todo:: do it events
             */
            throw new \Exception('Redirect');
        }
    }

    /**
     * @return \Service\Router
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getRouter():Router
    {
        return $this->container->get(ServiceConst::ROUTER);
    }
}