<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 8:45
 */

namespace Core\Service;


use Core\Service\Middleware\AbstractMiddleware;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class MiddlewareSplQueue extends \SplQueue
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * MiddlewareCollection constructor.
     * @param ContainerInterface $container
     * @param ConfigManager $configManager
     */
    public function __construct(ContainerInterface $container,ConfigManager $configManager)
    {
        $this->container = $container;
        $this->pushList($configManager->get()->getComponents()->getMiddlewares());
    }

    /**
     * @param array $middlewares
     */
    private function pushList(array $middlewares): void
    {
        foreach ($middlewares as $name) {
            $this->push($this->createMiddleware($name));
        }
    }

    /**
     * @return MiddlewareInterface
     */
    public function shift(): MiddlewareInterface
    {
        return parent::shift();
    }

    /**
     * @param string $key
     * @return int|null
     * @throws \Exception
     */
    private function getNumber(string $key): int
    {
        foreach ($this as $number => $item) {
            if ($item->getName() === $key) {
                return $number;
            }
        }
        throw new \RuntimeException('Key\'s Middleware -' . $key . ' is not exist');
    }

    /**
     * @param string $key
     * @param string $middleware
     * @throws \Exception
     */
    public function addBefore(string $key, string $middleware): void
    {
        $this->add($this->getNumber($key), $this->createMiddleware($middleware));
    }

    /**
     * @param string $key
     * @param string $middleware
     * @throws \Exception
     */
    public function addAfter(string $key, string $middleware): void
    {
        $this->add($this->getNumber($key) + 1, $this->createMiddleware($middleware));
    }

    private function createMiddleware(string $name): MiddlewareInterface
    {
        return new $name($this, $this->container);
    }

    public function current(): ?AbstractMiddleware
    {
        return parent::current();
    }
}