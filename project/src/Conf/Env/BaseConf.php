<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 17.04.18
 * Time: 14:26
 */

namespace Conf\Env;


use Core\Service\Entity\PropertyAccessInterface;

class BaseConf implements PropertyAccessInterface, EnvConfInterface
{

	protected $isProfiling;

	public function getProperties(): array
	{
		return [
			'isProfiling',
		];
	}

	public function isProfiling(): bool
	{
		return $this->isProfiling;
	}
}