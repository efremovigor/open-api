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
	 * @param \UrlAnalyzer  $urlAnalyzer
	 * @param \PathAnalyzer $pathAnalyzer
	 *
	 * @return bool
	 */
	public function checkRoute(UrlAnalyzer $urlAnalyzer, PathAnalyzer $pathAnalyzer): bool
	{
		if (count($pathAnalyzer->getMatches()) !== count($urlAnalyzer->getMatches())) {
			return false;
		}
		foreach ($pathAnalyzer->getMatches() as $key => $match) {
			if (!preg_match($match, $urlAnalyzer->getMatches()[$key])) {
				return false;
			}
		}
		return true;
	}
}