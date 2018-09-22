<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 26.04.18
 * Time: 15:59
 */

namespace Conf\Env;


class Prod extends BaseConf
{

	public function isProfiling(): bool
	{
		return false;
	}
}