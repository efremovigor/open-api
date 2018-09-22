<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:06
 */

namespace Middleware;


use Core\Service\Middleware\AbstractMiddleware;
use Psr\Log\LogLevel;
use Service\ServiceConst;

class RouterMiddleware extends AbstractMiddleware
{

	/**
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Exception
	 */
    protected function before(): void
    {
        $this->getLogger()->log(LogLevel::INFO,$this->container->get(ServiceConst::ROUTER)->getPath());
    }

    public function getName(): string
    {
        return 'router';
    }
}