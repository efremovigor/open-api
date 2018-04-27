<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 14:26
 */

namespace Service\Entity\Conf;


use Conf\EnvConfInterface;
use Service\Entity\PropertyAccessInterface;

class EnvConf implements PropertyAccessInterface , EnvConfInterface
{

    private $hostBalancer;
    private $hostSearch;
    private $hostESB;
    private $hostProof;
    private $hostContractor;
    private $hostPrintForms;
    private $hostRR;
    private $hostBitrix;
    private $hostExchange;
    private $hostSberbank;
    private $hostElasticSearch;
    private $portElasticSearch;


    public function getProperties(): array
    {
       return [
            'hostBalancer',
            'hostSearch',
            'hostESB',
            'hostProof',
            'hostContractor',
            'hostPrintForms',
            'hostRR',
            'hostBitrix',
            'hostExchange',
            'hostSberbank',
            'hostElasticSearch',
            'portElasticSearch',
       ];
    }

    /**
     * @return mixed
     */
    public function getHostBalancer():string
    {
        return $this->hostBalancer;
    }

    /**
     * @param mixed $hostBalancer
     */
    public function setHostBalancer($hostBalancer): void
    {
        $this->hostBalancer = $hostBalancer;
    }

    /**
     * @return mixed
     */
    public function getHostSearch():string
    {
        return $this->hostSearch;
    }

    /**
     * @param mixed $hostSearch
     */
    public function setHostSearch($hostSearch): void
    {
        $this->hostSearch = $hostSearch;
    }

    /**
     * @return mixed
     */
    public function getHostESB():string
    {
        return $this->hostESB;
    }

    /**
     * @param mixed $hostESB
     */
    public function setHostESB($hostESB): void
    {
        $this->hostESB = $hostESB;
    }

    /**
     * @return mixed
     */
    public function getHostProof():string
    {
        return $this->hostProof;
    }

    /**
     * @param mixed $hostProof
     */
    public function setHostProof($hostProof): void
    {
        $this->hostProof = $hostProof;
    }

    /**
     * @return mixed
     */
    public function getHostContractor():string
    {
        return $this->hostContractor;
    }

    /**
     * @param mixed $hostContractor
     */
    public function setHostContractor($hostContractor): void
    {
        $this->hostContractor = $hostContractor;
    }

    /**
     * @return mixed
     */
    public function getHostPrintForms():string
    {
        return $this->hostPrintForms;
    }

    /**
     * @param mixed $hostPrintForms
     */
    public function setHostPrintForms($hostPrintForms): void
    {
        $this->hostPrintForms = $hostPrintForms;
    }

    /**
     * @return mixed
     */
    public function getHostRR():string
    {
        return $this->hostRR;
    }

    /**
     * @param mixed $hostRR
     */
    public function setHostRR($hostRR): void
    {
        $this->hostRR = $hostRR;
    }

    /**
     * @return mixed
     */
    public function getHostBitrix():string
    {
        return $this->hostBitrix;
    }

    /**
     * @param mixed $hostBitrix
     */
    public function setHostBitrix($hostBitrix): void
    {
        $this->hostBitrix = $hostBitrix;
    }

    /**
     * @return mixed
     */
    public function getHostExchange():string
    {
        return $this->hostExchange;
    }

    /**
     * @param mixed $hostExchange
     */
    public function setHostExchange($hostExchange): void
    {
        $this->hostExchange = $hostExchange;
    }

    /**
     * @return mixed
     */
    public function getHostSberbank():string
    {
        return $this->hostSberbank;
    }

    /**
     * @param mixed $hostSberbank
     */
    public function setHostSberbank($hostSberbank): void
    {
        $this->hostSberbank = $hostSberbank;
    }

    /**
     * @return mixed
     */
    public function getHostElasticSearch():string
    {
        return $this->hostElasticSearch;
    }

    /**
     * @param mixed $hostElasticSearch
     */
    public function setHostElasticSearch($hostElasticSearch): void
    {
        $this->hostElasticSearch = $hostElasticSearch;
    }

    /**
     * @return mixed
     */
    public function getPortElasticSearch():string
    {
        return $this->portElasticSearch;
    }

    /**
     * @param mixed $portElasticSearch
     */
    public function setPortElasticSearch($portElasticSearch): void
    {
        $this->portElasticSearch = $portElasticSearch;
    }


}