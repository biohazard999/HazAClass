<?php

namespace HazAClass\System\Reflection\TestAttributes;

use HazAClass\System\Enum;

final class TestEnum extends Enum
{
	public static $classname = __CLASS__;
	const TEST_CONST = 'TEST_CONST_VALUE';

	public static function TestValue1()
	{
		return self::GetInstance(__FUNCTION__);
	}

	public static function TestValue2()
	{
		return self::GetInstance(__FUNCTION__);
	}

}

?>
