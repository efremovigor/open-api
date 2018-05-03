<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 25.04.18
 * Time: 14:03
 */

namespace Service\Entity\Routing;



use Core\Service\Entity\PropertyAccessInterface;

class Parameter implements PropertyAccessInterface
{
    private $value;
    private $type;

    public function getProperties(): array
    {
        return [
            'value',
            'type'
        ];
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


}