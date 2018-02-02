<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 9:54
 */

class RouterValidator
{

	/**
	 * @param \UrlAnalyzer  $analyzer
	 * @param \PathAnalyzer $pathAnalyzer
	 *
	 * @return bool
	 */
	public function checkRoute(UrlAnalyzer $analyzer, PathAnalyzer $pathAnalyzer): bool
	{
		if (count($pathAnalyzer->getMatches()) !== count($analyzer->getMatches())) {
			return false;
		}
		foreach ($pathAnalyzer->getMatches() as $key => $match) {
			if (!preg_match($match, $analyzer->getMatches()[$key])) {
				return false;
			}
		}
		return true;
	}
}