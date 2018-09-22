<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 18.04.18
 * Time: 13:52
 */

namespace Conf;


use Conf\Env\EnvConfInterface;

class MainConf
{
    /**
     * @var EnvConfInterface
     */
    private $envConf;
    /**
     * @var ComponentsInterface
     */
    private $components;

    /**
     * @return EnvConfInterface
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

    /**
     * @return mixed
     */
    public function getComponents(): ComponentsInterface
    {
        return $this->components;
    }

    /**
     * @param mixed $components
     */
    public function setComponents(ComponentsInterface $components): void
    {
        $this->components = $components;
    }
}