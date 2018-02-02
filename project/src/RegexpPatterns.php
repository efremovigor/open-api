<?php
/**
 * Created by PhpStorm.
 * User: igore
 * Date: 02.02.18
 * Time: 7:51
 */

class RegexpPatterns
{

	public const DELIMITER = '/';
	public const STRICT_START = self::DELIMITER . '^';
	public const CHOICE_STRICT_START = self::STRICT_START . '(';
	public const STRICT_END = '$' . self::DELIMITER;
	public const CHOICE_STRICT_END = self::STRICT_END . ')';
	public const CLEAR_STRING = '[a-z_0-9\.]{1,}';

	public const MATCH_ANY_ROUTE_VAR = self::STRICT_START . '{.*}' . self::STRICT_END;
	public const MATCH_MATRIX_ROUTE_VAR = self::STRICT_START . '{;'.self::CLEAR_STRING.'}' . self::STRICT_END;
	public const MATCH_CLEAR_STRING = self::STRICT_START . self::CLEAR_STRING . self::STRICT_END;

}