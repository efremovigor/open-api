<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 11:11
 */

namespace Middleware;


use Core\Service\CoreServiceConst;
use Core\Service\Middleware\AbstractMiddleware;
use Psr\Log\LogLevel;

class InitMiddleware extends AbstractMiddleware
{

	/**
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Exception
	 */
    protected function before(): void
    {
        $this->initConf();
    }

    public function getName(): string
    {
        return 'init';
    }

	/**
	 * @throws \Psr\Container\ContainerExceptionInterface
	 * @throws \Psr\Container\NotFoundExceptionInterface
	 * @throws \Exception
	 */
    private function initConf(): void
    {

        $this->getLogger()->log(LogLevel::INFO,$this->container->get(CoreServiceConst::CONF_MANAGER)->get());
    }

}