<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 20.04.18
 * Time: 23:09
 */

namespace Core\Container;


class ContainerItem implements ContainerItemInterface
{

    /**
     * @var string
     */
    private $class;
    /**
     * @var array
     */
    private $arg;

    public function __construct(string $class, array $arg = [])
    {

        $this->class = $class;
        $this->arg   = $arg;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getArguments(): array
    {
        return $this->arg;
    }
}