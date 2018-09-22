<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 26.04.18
 * Time: 16:00
 */

namespace Conf\Env;


class Test extends BaseConf
{

	public function isProfiling(): bool
	{
		return true;
	}
}