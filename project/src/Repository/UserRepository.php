<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 12:13
 */

namespace Repository;


use Builder\Orm\UserBuilder;
use Entity\User;

class UserRepository extends AbstractOrmRepository
{

	private function newBuilder(): UserBuilder
	{
		return new UserBuilder();
	}

	/**
	 * @param string $login
	 * @param        $password
	 *
	 * @return \Entity\User|null
	 * @throws \Exception
	 */
	public function getByCred(string $login, string $password): ?User
	{
		$query = $this->newBuilder()->getQueryCred($login, $password);
		return $this->serializer->normalize($this->fetchOne($query), User::class);
	}


	/**
	 * @param int $id
	 *
	 * @return \Entity\User|null
	 * @throws \Exception
	 */
	public function getById(int $id): ?User
	{
		$query = $this->newBuilder()->getById($id);
		return $this->serializer->normalize($this->fetchOne($query), User::class);
	}
}