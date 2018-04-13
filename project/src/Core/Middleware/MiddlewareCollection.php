<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 12.04.18
 * Time: 8:45
 */

namespace Core\Middleware;


use Psr\Http\Server\MiddlewareInterface;

class MiddlewareCollection extends \CollectionAbstract
{

    /**
     * MiddlewareCollection constructor.
     * @param array $elements
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $name) {
            parent::add($this->createMiddleware($name));
        }
    }

    /**
     * @return MiddlewareInterface[]
     */
    private function getAll(): array
    {
        return $this->elements;
    }

    /**
     * @return MiddlewareInterface
     */
    public function shift(): MiddlewareInterface
    {
        return array_shift($this->elements);
    }

    /**
     * @param string $key
     * @return int|null
     * @throws \Exception
     */
    private function getNumber(string $key): int
    {
        foreach ($this->getAll() as $number => $item) {
            if ($item->getName() === $key) {
                return $number;
            }
        }
        throw new \RuntimeException('Ключ Middleware not exist');
    }

    private function injectMiddleware(int $position, MiddlewareInterface $middleware): void
    {
        $this->elements = array_merge(
            array_merge(
                \array_slice($this->elements, 0, $position, true),
                [$middleware]
            ),
            \array_slice($this->elements, $position, \count($this->elements) - 1, true)
        );
    }

    /**
     * @param string $key
     * @param string $middleware
     * @throws \Exception
     */
    public function addBefore(string $key, string $middleware): void
    {
        $this->injectMiddleware($this->getNumber($key), $this->createMiddleware($middleware));
    }

    /**
     * @param string $key
     * @param string $middleware
     * @throws \Exception
     */
    public function addAfter(string $key, string $middleware): void
    {
        $this->injectMiddleware($this->getNumber($key) + 1, $this->createMiddleware($middleware));
    }

    private function createMiddleware(string $name): \Core\Middleware\MiddlewareInterface
    {
        return new $name($this);
    }
}