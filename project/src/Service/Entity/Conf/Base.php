<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 18.04.18
 * Time: 13:52
 */

namespace Service\Entity\Conf;


use Service\Entity\PropertyAccessInterface;

class Base implements PropertyAccessInterface
{

    private $parameters;
    private $devEmail;

    public function __construct()
    {
        $this->parameters = new ExternalConf();
    }

    public function getProperties(): array
    {
        return ['parameters', 'devEmail'];
    }

    /**
     * @return ExternalConf
     */
    public function getParameters(): ExternalConf
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

    /**
     * @return mixed
     */
    public function getDevEmail()
    {
        return $this->devEmail;
    }

    /**
     * @param mixed $dev_email
     */
    public function setDevEmail($dev_email): void
    {
        $this->devEmail = $dev_email;
    }
}