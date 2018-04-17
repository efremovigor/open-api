<?php
namespace Core\Container;

class YmlParser extends  AbstractContainerItem
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

    public function init(): void
    {
        // TODO: Implement init() method.
    }
}