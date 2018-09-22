<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:06
 */

namespace Middleware;


use Core\Response;
use Core\Service\Middleware\AbstractMiddleware;
use Psr\Log\LogLevel;
use Service\Router;
use Service\ServiceConst;
use Service\Templater;
use View\Template\TemplateConst;

class RouterMiddleware extends AbstractMiddleware
{

	/**
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Exception
	 */
    protected function before(): void
    {
        $this->getLogger()->log(LogLevel::INFO,$this->getRouter()->currentPath());
        $path = $this->getRouter()->currentPath();
        if($path === null){
            $this->setResponse(new Response($this->getTemplater()->render('404')));
            throw new \Exception(TemplateConst::ERROR404);
        }
    }

    public function getName(): string
    {
        return 'router';
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


    /**
     * @return \Service\Templater
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    private function getTemplater():Templater
    {
        return $this->container->get(ServiceConst::TEMPLATER);
    }
}