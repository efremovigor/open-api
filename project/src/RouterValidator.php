<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 9:54
 */

class RouterValidator
{

	public function checkRoute(UrlAnalyzer $analyzer, RoutingPath $routingPath)
	{
		var_dump($analyzer->getMatches());
		var_dump($routingPath->getMatches());
		$state = true;
		if (count($routingPath->getMatches()) !== count($analyzer->getMatches())) {
			$state = false;
		} else {
			foreach ($routingPath->getMatches() as $key => $match) {
				if (!preg_match($match, $analyzer->getMatches()[$key])) {
					$state = false;
					break;
				}

			}
		}

		var_dump('state = ' . (int)$state);
		var_dump('---------------------------------------------------------------------');
	}
}