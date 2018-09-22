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

	public function isProfiling(): bool;

	public function getSqlDsn();

	public function getSqlUser();

	public function getSqlPassword();

	public function getRedisHost();

	public function getRedisPort();

	public function getRedisPassword();

}