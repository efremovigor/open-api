<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 26.04.18
 * Time: 15:59
 */

namespace Conf\Env;


class Prod extends BaseConf
{

    public function isProfiling(): bool
    {
        return false;
    }

    /**
     * @return mixed
     */
    public function getSqlDsn(): string
    {
        return 'mysql:dbname=praga;host=containerhost;port=3306';
    }

    /**
     * @return mixed
     */
    public function getSqlUser(): string
    {
        return 'root';
    }

    /**
     * @return mixed
     */
    public function getSqlPassword(): ?string
    {
        return null;
    }


    /**
     * @return mixed
     */
    public function getRedisHost(): string
    {
        return 'containerhost';
    }

    /**
     * @return mixed
     */
    public function getRedisPort(): string
    {
        return '6379';
    }

    /**
     * @return mixed
     */
    public function getRedisPassword(): ?string
    {
        return null;
    }
}