<?php

namespace HazAClass\System\Reflection;

use HazAClass\System\Reflection\TestAttributes\TestAttribute;
use HazAClass\System\Reflection\TestAttributes\TestNamedAttribute;
use HazAClass\System\Reflection\TestAttributes\TestMixedAttribute;
use HazAClass\System\Collection\IList;
use HazAClass\System\Reflection\TestAttributes\ITestAttribute;
use HazAClass\System\Reflection\TestAttributes\TestEnum;

require_once dirname(__FILE__).'/../../../../HazAClass/System/Reflection/ReflectionProperty.php';

/**
 * Test class for ReflectionProperty.
 * Generated by PHPUnit on 2011-03-17 at 10:28:49.
 */
class ReflectionPropertyTest extends \PHPUnit_Framework_TestCase
{
	const PROPERTY_NAME = 'TestProperty';

	/**
	 * @var ReflectionMethod
	 */
	protected $object;

	protected function setUp()
	{
		$object = new ReflectionTestClass();
		$this->object = $object->GetType()->GetReflectionClass()->getProperty(self::PROPERTY_NAME);
	}

	protected function tearDown()
	{
		$this->object = null;
	}

	public function testHasAttributeNormal()
	{
		$this->assertTrue($this->object->HasAttribute(TestAttribute::$classname));
	}

	public function testHasAttributeNamed()
	{
		$this->assertTrue($this->object->HasAttribute(TestNamedAttribute::$classname));
	}

	public function testHasAttributeMixed()
	{
		$this->assertTrue($this->object->HasAttribute(TestMixedAttribute::$classname));
	}

	public function testGetAttributeNormal()
	{
		$this->assertInstanceOf(TestAttribute::$classname, $this->object->GetAttribute(TestAttribute::$classname));
	}

	public function testGetAttributeNamed()
	{
		$this->assertInstanceOf(TestNamedAttribute::$classname, $this->object->GetAttribute(TestNamedAttribute::$classname));
	}

	public function testGetAttributeMixed()
	{
		$this->assertInstanceOf(TestMixedAttribute::$classname, $this->object->GetAttribute(TestMixedAttribute::$classname));
	}

	public function testGetAttributes()
	{
		$this->assertInstanceOf(IList::IList, $this->object->GetAttributes());
	}

	public function testNormalAttribute()
	{
		$attr = $this->object->GetAttribute(TestAttribute::$classname);
		$this->AssertAttribute($attr);
	}

	public function testNamedAttribute()
	{
		$attr = $this->object->GetAttribute(TestNamedAttribute::$classname);
		$this->AssertAttribute($attr);
	}

	public function testMixedAttribute()
	{
		$attr = $this->object->GetAttribute(TestMixedAttribute::$classname);
		$this->AssertAttribute($attr);
	}

	protected function AssertAttribute(ITestAttribute $attr)
	{
		$this->assertEquals('teststring', $attr->getStringVar());
		$this->assertEquals(12345, $attr->getIntVar());
		$this->assertEquals(12.345, $attr->getDoubleVar());
		$this->assertSame(TestEnum::TestValue1(), $attr->getEnumVar());
		$this->assertEquals(true, $attr->getBoolVar());
		$this->assertEquals(TestEnum::$classname, $attr->getStaticVar());
		$this->assertEquals(TestEnum::TEST_CONST, $attr->getConstVar());
	}


	/**
	 * @todo Implement testGetSetterName().
	 */
	public function testGetSetterName()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	/**
	 * @todo Implement testGetGetterName().
	 */
	public function testGetGetterName()
	{
		// Remove the following lines when you implement this test.
		$this->markTestIncomplete(
			'This test has not been implemented yet.'
		);
	}

	public function testGetDeclaringClass()
	{
		$this->assertInstanceOf(ReflectionClass::$classname, $this->object->getDeclaringClass());
	}
}

?>
