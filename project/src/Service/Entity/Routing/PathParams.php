<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 25.04.18
 * Time: 12:52
 */

namespace Service\Entity\Routing;


use Core\AbstractCollection;
use Core\Service\Entity\ContainsCollectionInterface;

class PathParams extends AbstractCollection implements ContainsCollectionInterface
{
    public function getClass(): string
    {
        return Parameter::class;
    }

    public function getElements(): array
    {
        return $this->elements;
    }

    public function getOnlyParams(){
    }
}