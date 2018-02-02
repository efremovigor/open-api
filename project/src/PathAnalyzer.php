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
			if (preg_match(RegexpPatterns::MATCH_ANY_ROUTE_VAR, $part)) {
				$paramName = preg_replace('/[{}]*/', '', $part);
				if (isset($this->parameters[$paramName])) {
					switch ($this->parameters[$paramName]['type']) {
						case 'choice':
							$this->matches[] =
								RegexpPatterns::CHOICE_STRICT_START .
								$this->parameters[$paramName]['value'] .
								RegexpPatterns::CHOICE_STRICT_END;
							continue 2;
						case 'regexp':
							$this->matches[] =
								RegexpPatterns::STRICT_START .
								$this->parameters[$paramName]['value'] .
								RegexpPatterns::STRICT_END;
							continue 2;
					}
				} else {
					$this->matches[] = RegexpPatterns::CLEAR_STRING;
					continue;
				}
			}
			$this->matches[] = RegexpPatterns::STRICT_START . $part . RegexpPatterns::STRICT_END;
		}
	}

	public function getMatches(): array
	{
		return $this->matches;
	}
}