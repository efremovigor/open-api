<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 31.01.18
 * Time: 14:36
 */

class YmlParser
{
	public function getYml(string $path): array
	{
		if($this->isFile($path)){
			return yaml_parse_file($path);
		}
	}

	private function isFile(string $path) :bool
	{
		return file_exists($path) && pathinfo($path)['extension'] === 'yml';
	}
}