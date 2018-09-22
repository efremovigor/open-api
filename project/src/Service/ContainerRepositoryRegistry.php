<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 12:15
 */

namespace Service;


use Core\AbstractRegistry;
use Core\Container\ContainerItem;
use Core\Container\ContainerServiceRegistry;
use Core\Service\CoreServiceConst;

class ContainerRepositoryRegistry extends AbstractRegistry
{

	/**
	 * @return array|mixed
	 */
	protected function getServices()
	{
		return [
            RepositoryConst::USER  => new ContainerItem(RepositoryConst::USER, [ServiceConst::ORM_CONNECTION, CoreServiceConst::SERIALIZER]),
			RepositoryConst::REDIS => new ContainerItem(RepositoryConst::USER, [ServiceConst::REDIS_CONNECTION, CoreServiceConst::SERIALIZER]),
		];
	}

	public function __construct(ContainerServiceRegistry $container)
	{
		$this->services = $this->getServices();
	}
}