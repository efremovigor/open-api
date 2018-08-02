<?php

namespace Service;

use Core\Service\YmlParser;
use Service\Entity\Routing\Path;
use Service\Entity\Routing\RoutingCollection;
use Service\Router\UrlAnalyzer;

/**
 * Created by PhpStorm.
 * User: igore
 * Date: 31.01.18
 * Time: 14:32
 */
class Router
{

    /**
     * @var RoutingCollection
     */
    private $routingCollection;

    /**
     * @var string
     */
    private $requestUri;

    /**
     * @var Path|null
     */
    private $selectPath;

    /**
     * Router constructor.
     * @param YmlParser $parser
     * @throws \Exception
     */
    public function __construct(YmlParser $parser)
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->routingCollection = $parser->packPath(\Core\App::getConfDir() . '/routing.yml', RoutingCollection::class);
    }

    /**
     * @return null|Path
     * @throws \Exception
     */
    public function getPath(): ?Path
    {
        if ($this->selectPath === null) {
            $analyzer = new UrlAnalyzer();
            foreach ($this->routingCollection->getElements() as $path) {
                if (preg_match($analyzer->getMatch($path), $this->requestUri)) {
                    $this->selectPath = $path;
                    break;
                }
            }
        }
        return $this->selectPath;
    }
}