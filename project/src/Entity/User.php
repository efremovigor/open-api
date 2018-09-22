<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 11:49
 */

namespace Entity;


use Core\Service\Entity\PropertyAccessInterface;

class User implements PropertyAccessInterface
{
    protected $id;
	protected $login;
	protected $name;
	protected $surname;
	protected $cash;
	protected $bonusPoints;
	protected $items;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'id',
            'login',
            'name',
            'surname',
            'cash',
            'bonusPoints',
            'items',
        ];
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     */
    public function setLogin($login): void
    {
        $this->login = $login;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param mixed $surname
     */
    public function setSurname($surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return mixed
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param mixed $cash
     */
    public function setCash($cash): void
    {
        $this->cash = $cash;
    }

    /**
     * @return mixed
     */
    public function getBonusPoints()
    {
        return $this->bonusPoints;
    }

    /**
     * @param mixed $bonusPoints
     */
    public function setBonusPoints($bonusPoints): void
    {
        $this->bonusPoints = $bonusPoints;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }


}