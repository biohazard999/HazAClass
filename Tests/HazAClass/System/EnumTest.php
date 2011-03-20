<?php

namespace HazAClass\System;

require_once dirname(__FILE__).'/../../../HazAClass/System/Enum.php';

/**
 * Test class for Enum.
 * Generated by PHPUnit on 2011-03-10 at 16:09:34.
 */
class EnumTest extends \PHPUnit_Framework_TestCase
{

	public function testEnumInstanceIsAlwaysTheSame()
	{
		$this->assertSame(TestEnum::MyValue1(), TestEnum::MyValue1());
	}

	public function testEnumInstanceValuesAreNotTheTheSame()
	{
		$this->assertNotSame(TestEnum::MyValue1(), TestEnum::MyValue2());
	}

	public function testGetValue()
	{
		$this->assertEquals('1', TestEnum::MyValue1()->getValue());
		$this->assertEquals(TestEnum::MyValue3()->getValue(), TestEnum::MyValue2()->getValue());
		$this->assertEquals('MyValue3', TestEnum::MyValue3()->getValue());

	}

	public function testToString()
	{
		$this->assertEquals('1', (string) TestEnum::MyValue1());
		$this->assertEquals(TestEnum::MyValue3()->ToString(), (string) TestEnum::MyValue2());
		$this->assertEquals('MyValue3', (string) TestEnum::MyValue3());
	}

}


class TestEnum extends Enum
{
	public static $classname = __CLASS__;

	public static function MyValue1()
	{
		return self::getInstance('1');
	}

	public static function MyValue2()
	{
		return self::getInstance('MyValue3');
	}

	public static function MyValue3()
	{
		return self::getInstance(__FUNCTION__);
	}
}

?>