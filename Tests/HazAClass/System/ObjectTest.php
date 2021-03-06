<?php

namespace HazAClass\System;

require_once dirname(__FILE__).'/../../../HazAClass/System/Object.php';

/**
 * Test class for Object.
 * Generated by PHPUnit on 2011-03-09 at 11:12:14.
 */
class ObjectTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var ObjectImpl
	 */
	protected $object1;
	/**
	 * @var ObjectImpl
	 */
	protected $object2;

	protected function setUp()
	{
		$this->object1 = new ObjectImpl();
		$this->object2 = new ObjectImpl();
	}

	protected function tearDown()
	{
		$this->object1 = null;
		$this->object2 = null;
	}

	public function testGetHash()
	{
		$this->assertEquals(spl_object_hash($this->object1), $this->object1->GetHash());
		$this->assertEquals(spl_object_hash($this->object2), $this->object2->GetHash());
		$this->assertNotEquals($this->object1->GetHash(), $this->object2->GetHash());
	}

	public function testToString()
	{
		$this->assertEquals($this->buildName($this->object1), $this->object1->ToString());
		$this->assertEquals($this->buildName($this->object2), $this->object2->ToString());
		$this->assertNotEquals($this->object1->ToString(), $this->object2->ToString());
	}

	public function test__toString()
	{
		$this->assertEquals($this->buildName($this->object1), (string) $this->object1);
		$this->assertEquals($this->buildName($this->object2), (string) $this->object2);
		$this->assertNotEquals((string) $this->object1, (string) $this->object2);
	}

	private function buildName(Object $obj)
	{
		return get_class($obj).' ('.spl_object_hash($obj).')';
	}

	public function testGetType()
	{
		$this->assertInstanceOf(Type::$classname, $this->object1->GetType());
		$this->assertInstanceOf(Type::$classname, $this->object1->GetType());
		$this->assertSame($this->object1->GetType(), $this->object2->GetType());
	}

	public function testGetClassName()
	{
		$this->assertEquals(get_class($this->object1), $this->object1->GetClassName());
		$this->assertEquals(get_class($this->object2), $this->object2->GetClassName());
		$this->assertEquals($this->object1->GetClassName(), $this->object2->GetClassName());
	}

	public function testReferencesShouldBeEqualStatic()
	{
		$a = new ObjectImpl();
		$this->assertTrue(Object::ReferenceEqualsStatic($a, $a));
	}

	public function testReferencesShouldNotBeEqualStatic()
	{
		$this->assertFalse(Object::ReferenceEqualsStatic( new ObjectImpl(), new ObjectImpl()));
	}

	public function testReferencesShouldBeEqual()
	{
		$this->assertTrue($this->object1->ReferenceEquals($this->object1));
	}

	public function testReferencesShouldNotBeEqual()
	{
		$this->assertFalse($this->object1->ReferenceEquals($this->object2));
	}

}

class ObjectImpl extends Object
{
	
}

?>
