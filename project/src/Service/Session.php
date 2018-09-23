<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 23.09.18
 * Time: 20:25
 */

namespace Service;


use Entity\User;
use Repository\RedisRepository;

class Session
{
    /**
     * @var RedisRepository
     */
    private $repository;

    public function __construct(RedisRepository $repository)
    {

        $this->repository = $repository;
    }

    /**
     * @return User|null
     * @throws \Exception
     */
    public function getUser():?User
    {
       return $this->repository->getBySession($_SESSION['USER_KEY']);
    }

}