<?php

namespace Service;

class YmlParser
{
    /**
     * @var Serializer
     */
    private $serializer;

    public function getYml(string $path): array
    {
        if ($this->isFile($path)) {
            $resource = yaml_parse_file($path);
            $place = $this->getPathPlace($path);
            if (isset($resource['imports']) && \is_array($resource['imports'])) {
                foreach ($resource['imports'] as $file) {
                    $resource = $this->serializer->normalize(
                        $this->getYml($place . '/' . $file),
                        $resource,
                        [Serializer::REWRITABLE, Serializer::ADDABLE]
                    );
                }
            }

            return $resource;
        }

        return [];
    }

    public function packPath(string $path, string $class)
    {
        return $this->serializer->normalize($this->getYml($path), $class, [Serializer::REWRITABLE, Serializer::ADDABLE]);
    }

    private function isFile(string $path): bool
    {
        return file_exists($path) && pathinfo($path)['extension'] === 'yml';
    }

    /**
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    private function getPathPlace(string $path): string
    {
        $place = explode('/', $path);
        array_pop($place);

        return implode('/', $place);
    }
}