<?php

namespace HazAClass\System\Collection\Generic;

use HazAClass\System\Object;
use HazAClass\System\Collection\AbstractListTest;

require_once dirname(__FILE__).'/../../../../../HazAClass/System/Collection/Generic/GenericList.php';

/**
 * Test class for GenericList.
 * Generated by PHPUnit on 2011-03-09 at 11:26:28.
 */
class GenericListTest extends AbstractListTest
{

	protected function setUp()
	{
		$this->list = new GenericList(Object::$classname);
	}

	protected function tearDown()
	{
		$this->list = null;
	}

	public function ElementDataProvider()
	{
		return array(
			array(0, 1, new TestClass1(), new TestClass2()),
			array(4, 7, new TestClass2(), new TestClass1()),
		);
	}

}

class TestClass1 extends Object
{

	public static $classname = __CLASS__;

}

class TestClass2 extends Object
{

	public static $classname = __CLASS__;

}

?>
