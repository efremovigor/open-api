<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 22.09.18
 * Time: 12:28
 */

namespace Builder\Orm;


class UserBuilder
{

	/**
	 * @param string $login
	 * @param        $password
	 *
	 * @return \Entity\User
	 */
	public function getQueryCred(string $login,string $password): string
	{
		return sprintf('SELECT ... FROM user u WHERE u.login = "%s" AND u.password = "%s"',$login, $password);
	}

	public function getById(int $id): string
	{
		return sprintf('SELECT ... FROM user u WHERE u.id = "%d"',$id);
	}
}