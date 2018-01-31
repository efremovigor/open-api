<?php


class Kernel
{

	public function getAppDir(): string
	{
		return __DIR__;
	}

    public function getRootDir(): string
    {
        return __DIR__.'/..';
    }

    public function getCacheDir():string
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

	/**
	 * @return string
	 */
	public function getLogDir():string
    {
        return dirname(__DIR__).'/var/logs';
    }

	private function getEnvironment(): string
	{
		return 'prod';
	}

}
