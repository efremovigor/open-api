<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 11:49
 */

namespace Entity;


use Core\Service\Entity\PropertyAccessInterface;

/**
 * Class User
 * @package Entity
 */
class User implements PropertyAccessInterface
{
    protected $id;
	protected $login;
	protected $name;
	protected $surname;
	protected $gifts;

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

    public function __construct()
    {
        $this->gifts = new GiftList();
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


}