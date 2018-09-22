<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 8:51
 */

namespace Service\Entity\Routing;

use Core\Service\Entity\PropertyAccessInterface;

class Path implements PropertyAccessInterface
{
    private $route;
    private $controller;
    private $action;
    private $methods;
    private $defaults = [];
    private $patternParams;
    private $requestParams;

    public function getProperties(): array
    {
        return [
            'route',
            'controller',
            'action',
            'methods',
            'defaults',
        ];
    }

    public function __construct()
    {
        $this->patternParams = new PathParams();
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param mixed $route
     */
    public function setRoute($route): void
    {
        $this->route = $route;
    }

    /**
     * @return mixed
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @param mixed $controller
     */
    public function setController($controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return mixed
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param mixed $action
     */
    public function setAction($action): void
    {
        $this->action = $action;
    }

    /**
     * @return mixed
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param mixed $methods
     */
    public function setMethods($methods): void
    {
        $this->methods = $methods;
    }

    /**
     * @return array
     */
    public function getDefaults(): array
    {
        return $this->defaults;
    }

    /**
     * @param array $defaults
     */
    public function setDefaults(array $defaults): void
    {
        $this->defaults = $defaults;
    }

    /**
     * @return PathParams
     */
    public function getPatternParams(): PathParams
    {
        return $this->patternParams;
    }

    /**
     * @param $patternParams
     */
    public function addPatternParams($patternParams): void
    {
        $this->patternParams->add($patternParams);
    }


}