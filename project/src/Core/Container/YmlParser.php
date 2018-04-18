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
            $resource[] = yaml_parse_file($path);
            $place = $this->getPathPlace($path);
            if (isset($resource[0]['imports']) && \is_array($resource[0]['imports'])) {
                foreach ($resource[0]['imports'] as $file) {
                    $resource[] = $this->getYml($place . '/' . $file);
                }
            }
            $resource = array_merge(...$resource);
            return $resource;
        }
        return [];
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

    private function getPathPlace(string $path)
    {
        $place = explode('/', $path);
        array_pop($place);
        return implode('/', $place);
    }
}