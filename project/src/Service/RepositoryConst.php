<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 16.04.18
 * Time: 14:46
 */

namespace Service;

use Core\Container\ContainerRepositoryRegistry;
use Repository\RedisRepository;
use Repository\UserRepository;

final class RepositoryConst
{
    public const USER = UserRepository::class;
    public const REDIS = RedisRepository::class;
}