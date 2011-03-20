<?php

namespace HazAClass\System\Reflection;

use HazAClass\System\Reflection\TestAttributes\TestAttribute;
use HazAClass\System\Reflection\TestAttributes\TestNamedAttribute;
use HazAClass\System\Reflection\TestAttributes\TestMixedAttribute;
use HazAClass\System\Reflection\TestAttributes\ITestAttribute;
use HazAClass\System\Collection\IList;
use HazAClass\System\Reflection\TestAttributes\TestEnum;
use HazAClass\System\Object;

require_once dirname(__FILE__).'/../../../../HazAClass/System/Reflection/ReflectionClass.php';

/**
 * Test class for ReflectionClass.
 * Generated by PHPUnit on 2011-03-17 at 10:28:48.
 */
class ReflectionClassTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var ReflectionTestClass
	 */
	protected $object;

	protected function setUp()
	{
		$this->object = new ReflectionTestClass();
	}

	protected function tearDown()
	{
		$this->object = null;
	}

	public function testHasAttributeNormal()
	{
		$this->assertTrue($this->object->GetType()->GetReflectionClass()->HasAttribute(TestAttribute::$classname));
	}

	public function testHasAttributeNamed()
	{
		$this->assertTrue($this->object->GetType()->GetReflectionClass()->HasAttribute(TestNamedAttribute::$classname));
	}

	public function testHasAttributeMixed()
	{
		$this->assertTrue($this->object->GetType()->GetReflectionClass()->HasAttribute(TestMixedAttribute::$classname));
	}

	public function testGetAttributeNormal()
	{
		$this->assertInstanceOf(TestAttribute::$classname, $this->object->GetType()->GetReflectionClass()->GetAttribute(TestAttribute::$classname));
	}

	public function testGetAttributeNamed()
	{
		$this->assertInstanceOf(TestNamedAttribute::$classname, $this->object->GetType()->GetReflectionClass()->GetAttribute(TestNamedAttribute::$classname));
	}

	public function testGetAttributeMixed()
	{
		$this->assertInstanceOf(TestMixedAttribute::$classname, $this->object->GetType()->GetReflectionClass()->GetAttribute(TestMixedAttribute::$classname));
	}

	public function testGetAttributes()
	{
		$this->assertInstanceOf(IList::IList, $this->object->GetType()->GetReflectionClass()->GetAttributes());
	}

	public function testNormalAttribute()
	{
		$attr = $this->object->GetType()->GetReflectionClass()->GetAttribute(TestAttribute::$classname);
		$this->AssertAttribute($attr);
	}

	public function testNamedAttribute()
	{
		$attr = $this->object->GetType()->GetReflectionClass()->GetAttribute(TestNamedAttribute::$classname);
		$this->AssertAttribute($attr);
	}

	public function testMixedAttribute()
	{
		$attr = $this->object->GetType()->GetReflectionClass()->GetAttribute(TestMixedAttribute::$classname);
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

	public function testGetConstructor()
	{
		$this->assertInstanceOf(ReflectionMethod::$classname, $this->object->GetType()->GetReflectionClass()->getConstructor());
	}

	public function testGetMethod()
	{
		$method = $this->object->GetType()->GetReflectionClass()->getMethod('TestMethod');
		$this->assertInstanceOf(ReflectionMethod::$classname, $method);
		$this->assertEquals('TestMethod', $method->getName());
	}

	public function testGetMethods()
	{
		$methods = $this->object->GetType()->GetReflectionClass()->getMethods();
		$this->assertEquals(9, $methods->count());
		$this->assertInstanceOf(IList::IList, $methods);
	}

	public function testGetProperty()
	{
		$prop = $this->object->GetType()->GetReflectionClass()->getProperty('TestProperty');
		$this->assertInstanceOf(ReflectionProperty::$classname, $prop);
		$this->assertEquals('TestProperty', $prop->getName());
	}

	public function testGetProperties()
	{
		$properties = $this->object->GetType()->GetReflectionClass()->getProperties();
		$this->assertEquals(3, $properties->count());
		$this->assertInstanceOf(IList::IList, $properties);
	}

	public function testGetInterfaces()
	{
		$interfaces = $this->object->GetType()->GetReflectionClass()->getInterfaces();
		$this->assertInstanceOf(IList::IList, $interfaces);
		$this->assertEquals(2, $interfaces->count());
	}

	public function testGetParentClass()
	{
		$this->assertInstanceOf(ReflectionClass::$classname, $this->object->GetType()->GetReflectionClass()->getParentClass());
		$this->assertEquals(Object::$classname, $this->object->GetType()->GetReflectionClass()->getParentClass()->getName());
	}

	public function testGetUsings()
	{
		$this->assertInstanceOf(IList::IList, $this->object->GetType()->GetReflectionClass()->GetUsings());
	}

}

?>
