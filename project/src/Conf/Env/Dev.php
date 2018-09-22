<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 26.04.18
 * Time: 15:59
 */

namespace Conf\Env;


class Dev extends BaseConf
{

    public function isProfiling(): bool
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function getSqlDsn(): string
    {
        return 'mysql:dbname=testdb;host=127.0.0.1';
    }

    /**
     * @return mixed
     */
    public function getSqlUser(): string
    {
        return 'dbuser';
    }

    /**
     * @return mixed
     */
    public function getSqlPassword(): string
    {
        return 'dbpass';
    }

    /**
     * @return mixed
     */
    public function getRedisHost(): string
    {
        return $this->redisHost;
    }

    /**
     * @return mixed
     */
    public function getRedisPort(): string
    {
        return $this->redisPort;
    }

    /**
     * @return mixed
     */
    public function getRedisPassword(): string
    {
        return $this->redisPassword;
    }

}