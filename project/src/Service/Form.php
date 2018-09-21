<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:37
 */

namespace Service;

use Core\Service\Serializer;

class Form
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

}