<?php


class Kernel
{
    public function getRootDir(): string
    {
        return __DIR__;
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

	private function getEnvironment()
	{
		return 'prod';
	}

	//public function registerContainerConfiguration(LoaderInterface $loader)
    //{
    //    $loader->load($this->getRootDir().'/config/'.$this->getEnvironment().'/config.yml');
    //}
}
