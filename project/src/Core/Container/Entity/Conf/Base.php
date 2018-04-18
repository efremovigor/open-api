<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 18.04.18
 * Time: 13:52
 */

namespace Core\Container\Entity\Conf;


use Core\Container\Entity\PropertyAccessInterface;

class Base implements PropertyAccessInterface
{

    private $parameters;

    public function __construct()
    {
        $this->parameters = new ExternalConf();
    }

    public function getProperties(): array
    {
        return ['parameters'];
    }

    /**
     * @return ExternalConf
     */
    public function getParameters() :ExternalConf
    {
        return $this->parameters;
    }

    /**
     * @param mixed $parameters
     */
    public function setParameters($parameters): void
    {
        $this->parameters = $parameters;
    }
}