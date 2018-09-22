<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 18:49
 */

namespace Entity\Form;


use Core\Service\Entity\PropertyAccessInterface;

class Login implements PropertyAccessInterface
{
    private $login;
    private $password;

    /**
     * @return array
     */
    public function getProperties(): array
    {
        return [
            'login',
            'password',
        ];
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
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }


    public function isValid(): bool
    {
        return !empty($this->password) && (bool)filter_var($this->login, FILTER_VALIDATE_EMAIL);
    }
}