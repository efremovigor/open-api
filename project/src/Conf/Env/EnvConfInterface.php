<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 26.04.18
 * Time: 16:00
 */

namespace Conf\Env;


interface EnvConfInterface
{
    public function getHostBalancer(): string;

    public function getHostSearch(): string;

    public function getHostESB(): string;

    public function getHostProof(): string;

    public function getHostContractor(): string;

    public function getHostPrintForms(): string;

    public function getHostRR(): string;

    public function getHostBitrix(): string;

    public function getHostExchange(): string;

    public function getHostSberbank(): string;

    public function getHostElasticSearch(): string;

    public function getPortElasticSearch(): string;

    public function isProfiling(): bool;

}