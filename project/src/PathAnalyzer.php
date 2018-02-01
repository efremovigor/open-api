<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 11:53
 */

class PathAnalyzer extends ARouteAnalyzer
{

	private $parameters = [];

	private $matches = [];

	/**
	 * @param array $parameters
	 */
	public function setParameters(array $parameters): void
	{
		$this->parameters = $parameters;
	}

	public function processing(): void
	{
		$this->parts = explode('/', $this->route);
		foreach ($this->parts as $part) {
			if (preg_match('/^{.*}$/', $part)) {
				$paramName = preg_replace('/[{}]*/', '', $part);
				if (isset($this->parameters[$paramName])) {
					switch ($this->parameters[$paramName]['type']) {
						case 'choice':
							$this->matches[] = '/^(' . $this->parameters[$paramName]['value'] . ')$/';
							continue 2;
						case 'regexp':
							$this->matches[] = '/^' . $this->parameters[$paramName]['value'] . '$/';
							continue 2;
					}
				} else {
					$this->matches[] = '/^[a-z_0-9\.]{2,}$/';
					continue;
				}
			}
			$this->matches[] = '/^'.$part.'$/';
		}
	}

	public function getMatches(): array
	{
		return $this->matches;
	}
}