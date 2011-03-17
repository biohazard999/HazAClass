<?php

namespace HazAClass\System\Reflection;

use HazAClass\System\Object;
use HazAClass\System\Reflection\TestAttributes\TestAttribute;
use HazAClass\System\Reflection\TestAttributes\TestNamedAttribute;
use HazAClass\System\Reflection\TestAttributes\TestEnum;
use HazAClass\System\Reflection\TestAttributes\TestMixedAttribute;

/**
 * @TestAttribute('teststring', 12345, 12.345, TestEnum::TestValue1(), true, TestEnum::$classname, TestEnum::TEST_CONST)
 * @TestNamedAttribute(
 *   stringVar = 'teststring',
 *   intVar = 12345,
 *   doubleVar = 12.345,
 *   enumVar = TestEnum::$classname,
 *   boolVar = true,
 *   staticVar = TestEnum::$classname,
 *   constVar = TestEnum::TEST_CONST
 * )
 * @TestMixedAttribute(
 *   'teststring',
 *   12345,
 *   12.345,
 *   enumVar = TestEnum::$classname,
 *   boolVar = true,
 *   staticVar = TestEnum::$classname,
 *   constVar = TestEnum::TEST_CONST
 * )
 */
class ReflectionTestClass extends Object
{

	public static $classname = __CLASS__;
	/**
	 * @TestAttribute('teststring', 12345, 12.345, TestEnum::TestValue1(), true, TestEnum::$classname, TestEnum::TEST_CONST)
	 * @TestNamedAttribute(
	 *   stringVar = 'teststring',
	 *   intVar = 12345,
	 *   doubleVar = 12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 * @TestMixedAttribute(
	 *   'teststring',
	 *   12345,
	 *   12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 */
	public static $TestStaticProperty = __CLASS__;

	/**
	 * @TestAttribute('teststring', 12345, 12.345, TestEnum::TestValue1(), true, TestEnum::$classname, TestEnum::TEST_CONST)
	 * @TestNamedAttribute(
	 *   stringVar = 'teststring',
	 *   intVar = 12345,
	 *   doubleVar = 12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 * @TestMixedAttribute(
	 *   'teststring',
	 *   12345,
	 *   12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 */
	const TEST_CONST = 123;

	/**
	 * @TestAttribute('teststring', 12345, 12.345, TestEnum::TestValue1(), true, TestEnum::$classname, TestEnum::TEST_CONST)
	 * @TestNamedAttribute(
	 *   stringVar = 'teststring',
	 *   intVar = 12345,
	 *   doubleVar = 12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 * @TestMixedAttribute(
	 *   'teststring',
	 *   12345,
	 *   12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 */
	public $TestProperty;

	/**
	 * @TestAttribute('teststring', 12345, 12.345, TestEnum::TestValue1(), true, TestEnum::$classname, TestEnum::TEST_CONST)
	 * @TestNamedAttribute(
	 *   stringVar = 'teststring',
	 *   intVar = 12345,
	 *   doubleVar = 12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 * @TestMixedAttribute(
	 *   'teststring',
	 *   12345,
	 *   12.345,
	 *   enumVar = TestEnum::$classname,
	 *   boolVar = true,
	 *   staticVar = TestEnum::$classname,
	 *   constVar = TestEnum::TEST_CONST
	 * )
	 */
	public function TestMethod()
	{

	}

}

?>
