<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 8:45
 */

namespace Core\Middleware;


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
     * @param array $elements
     * @param ContainerInterface $container
     */
    public function __construct(array $elements = [], ContainerInterface $container)
    {
        $this->container = $container;
        foreach ($elements as $name) {
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

    private function createMiddleware(string $name): \Core\Middleware\MiddlewareInterface
    {
        return new $name($this, $this->container);
    }
}