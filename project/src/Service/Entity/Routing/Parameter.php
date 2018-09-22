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
    private $expr;
    private $type;
    private $value;

    public function getProperties(): array
    {
        return [
            'expr',
            'type'
        ];
    }

    /**
     * @return mixed
     */
    public function getExpr()
    {
        return $this->expr;
    }

    /**
     * @param mixed $expr
     */
    public function setExpr($expr): void
    {
        $this->expr = $expr;
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


}