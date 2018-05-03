<?php

namespace Service\Entity\Routing;

use Core\AbstractCollection;
use Core\Service\Entity\ContainsCollectionInterface;

/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 8:46
 */
class RoutingCollection extends AbstractCollection implements ContainsCollectionInterface
{
    /**
     * @return Path[]
     */
    public function getAll(): array
    {
        return $this->elements;
    }

    public function getClass(): string
    {
        return Path::class;
    }
}