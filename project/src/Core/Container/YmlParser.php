<?php

namespace Core\Container;

class YmlParser extends AbstractContainerItem
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function getYml(string $path): array
    {
        if ($this->isFile($path)) {
            return yaml_parse_file($path);
        }
    }

    public function packPath(string $path, string $class)
    {
        return $this->serializer->normalize($this->getYml($path), $class);
    }

    private function isFile(string $path): bool
    {
        return file_exists($path) && pathinfo($path)['extension'] === 'yml';
    }

    public function init(): void
    {
        $this->serializer = $this->container->get(Registry::SERIALIZER);
    }
}