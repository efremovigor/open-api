<?php

namespace Service;

use RouterValidator;
use RoutingManager;
use RoutingPath;
use Service\Entity\Routing\RoutingCollection;
use UrlAnalyzer;

/**
 * Created by PhpStorm.
 * User: igore
 * Date: 31.01.18
 * Time: 14:32
 */
class Router
{

    /**
     * @var UrlAnalyzer
     */
    private $routeAnalyzer;

    /**
     * @var RoutingCollection
     */
    private $routingCollection;

    /**
     * Router constructor.
     * @param YmlParser $parser
     */
    public function __construct(YmlParser $parser)
    {
        $this->routingCollection = $parser->packPath(\Core\App::getConfDir() . '/routing.yml', RoutingCollection::class);
        $this->routeAnalyzer = new UrlAnalyzer($_SERVER['REQUEST_URI']);
        $this->routeAnalyzer->processing();
//		var_dump($this->getPathRoute());
    }

    /**
     * @return \UrlAnalyzer
     */
    public function getRouteAnalyzer(): UrlAnalyzer
    {
        return $this->routeAnalyzer;
    }

    /**
     * @return null|RoutingPath
     */
    public function getPathRoute(): ?RoutingPath
    {
        $validator = new RouterValidator();
        foreach ($this->routingCollection->getAll() as $item) {
            $valid = $validator->checkRoute($this->routeAnalyzer, $item->getPathAnalyzer());
            if ($valid === true) {
                return $item;
            }
        }
        return null;
    }
}