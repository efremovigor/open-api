<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 9:59
 */

class UrlAnalyzer extends RouteAnalyzerAbstract
{

	/**
	 * @var array
	 */
	protected $params = [];

	public function processing(): void
	{
		$urlParts = parse_url($this->route);
		if (isset($urlParts['query'])) {
			parse_str($urlParts['query'], $this->params);
		}
		$this->parts = explode('/', $urlParts['path']);
	}

	/**
	 * @return mixed
	 */
	public function getParams()
	{
		return $this->params;
	}

	public function getMatches(): array
	{
		return $this->parts;
	}

}