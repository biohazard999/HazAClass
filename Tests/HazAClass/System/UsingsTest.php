<?php

namespace HazAClass\System;

use HazAClass\System\TestUsings\UsingsTestClass;
use HazAClass\System\Collection\IList;

class UsingsTest extends \PHPUnit_Framework_TestCase
{

	protected $usingsObject;

	protected function setUp()
	{
		$this->usingsObject = new UsingsTestClass();
	}

	protected function tearDown()
	{
		$this->usingsObject = null;
	}

	public function testGetUsings()
	{
		$ref = $this->usingsObject->GetType()->GetReflectionClass();

		$this->assertEquals(Object::$classname, $ref->GetUsings()->offsetGet('Object'));
		$this->assertEquals(Attribute::$classname, $ref->GetUsings()->offsetGet('Attribute'));
		$this->assertEquals(Autoload::$classname, $ref->GetUsings()->offsetGet('Auto'));
		$this->assertEquals(Enum::$classname, $ref->GetUsings()->offsetGet('Enum'));
		$this->assertEquals(String::$classname, $ref->GetUsings()->offsetGet('String'));
	}

	public function testCountUsings()
	{
		$ref = $this->usingsObject->GetType()->GetReflectionClass();
		$this->assertEquals(5, $ref->GetUsings()->count());
	}

	public function testInstanceOfUsingsList()
	{
		$this->assertInstanceOf(IList::IList, $this->usingsObject->GetType()->GetReflectionClass()->GetUsings());
	}

}

?>
