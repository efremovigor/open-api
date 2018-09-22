<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 12:39
 */

namespace Repository;


use Core\Service\Serializer;
use Service\OrmConnection;

abstract class AbstractOrmRepository
{

	/**
	 * @var \Core\Service\Serializer
	 */
	protected $serializer;

	/**
	 * @var \Service\OrmConnection
	 */
	private $connectionOrmService;


	/**
	 * AbstractOrmRepository constructor.
	 *
	 * @param \Service\OrmConnection   $connectionOrmService
	 * @param \Core\Service\Serializer $serializer
	 */
	public function __construct(OrmConnection $connectionOrmService, Serializer $serializer)
	{
		$this->connectionOrmService = $connectionOrmService;
		$this->serializer = $serializer;
	}

	/**
	 * @param string $query
	 *
	 * @return array|null
	 */
	public function fetchOne(string $query): ?array
	{
		return $this->connectionOrmService->getConnection()->query($query)->fetch();
	}

	public function fetchAll(string $query): array
	{
		return $this->connectionOrmService->getConnection()->query($query)->fetchAll();
	}
}