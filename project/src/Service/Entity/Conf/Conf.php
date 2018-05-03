<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 18.04.18
 * Time: 13:52
 */

namespace Service\Entity\Conf;


use Conf\EnvConfInterface;

class Conf
{

    private $envConf;

    /**
     * @return EnvConf
     */
    public function getEnvConf(): EnvConfInterface
    {
        return $this->envConf;
    }

    /**
     * @param mixed $envConf
     */
    public function setEnvConf(EnvConfInterface $envConf): void
    {
        $this->envConf = $envConf;
    }
}