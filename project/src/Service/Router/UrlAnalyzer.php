<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 26.04.18
 * Time: 10:11
 */

namespace Service\Router;

use Service\Entity\Routing\Parameter;
use Service\Entity\Routing\Path;

class UrlAnalyzer
{

    public const DELIMITER = '/';
    public const STRICT_START = self::DELIMITER . '^';
    public const CHOICE_STRICT_START = self::STRICT_START . '(';
    public const STRICT_END = '$' . self::DELIMITER;
    public const CHOICE_STRICT_END = self::STRICT_END . ')';
    public const CLEAR_STRING = '[a-z_0-9\.]{1,}';

    public const MATCH_ANY_ROUTE_VAR = self::STRICT_START . '{.*}' . self::STRICT_END;
    public const MATCH_MATRIX_ROUTE_VAR = self::STRICT_START . '{;' . self::CLEAR_STRING . '}' . self::STRICT_END;
    public const MATCH_CLEAR_STRING = self::STRICT_START . self::CLEAR_STRING . self::STRICT_END;

    /**
     * @param Path $path
     * @return string
     * @throws \Exception
     */
    public function getMatch(Path $path): string
    {
        $parts = explode('/', $path->getRoute());
        $matches = [];
        foreach ($parts as $part) {
            if (preg_match(self::MATCH_ANY_ROUTE_VAR, $part)) {
                $paramName = preg_replace('/[{}]*/', '', $part);
                if (preg_match(self::MATCH_MATRIX_ROUTE_VAR, $part)) {
                    $matches[] = $paramName . '=' . self::CLEAR_STRING . '(,' . self::CLEAR_STRING . ')*';
                    continue;
                }
                if ($path->getPatternParams()->has($paramName)) {
                    /**
                     * @var $parameter Parameter
                     */
                    $parameter = $path->getPatternParams()->get($paramName);
                    switch ($parameter->getType()) {
                        case 'choice':
                            $matches[] = '(?P<' . $paramName . '>(' . $parameter->getExpr() . '))';
                            continue 2;
                        case 'regexp':
                            $matches[] = '(?P<' . $paramName . '>' . $parameter->getExpr() . ')';
                            continue 2;
                    }
                }
                $matches[] = self::CLEAR_STRING;
                continue;
            }
            $matches[] = $part;
        }
        return self::STRICT_START . implode('\/', $matches) . self::STRICT_END . 'u';
    }
}