<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 01.02.18
 * Time: 8:51
 */

class RoutingPath
{

	private $pathAnalyzer;

	public function __construct($routing)
	{
		$this->path = $routing['path'];
		$this->data = $routing;

		$this->pathAnalyzer = new PathAnalyzer($routing['path']);
		if (isset($routing['parameters'])) {
			$this->pathAnalyzer->setParameters($routing['parameters']);
		}
		$this->pathAnalyzer->processing();
	}

	public function getMatches(): array
	{
		return $this->pathAnalyzer->getMatches();
	}
}