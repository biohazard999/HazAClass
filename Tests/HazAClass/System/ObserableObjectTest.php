<?php

namespace HazAClass\System;

require_once dirname(__FILE__).'/../../../HazAClass/System/OberserableObject.php';

/**
 * Test class for ObserableObject.
 * Generated by PHPUnit on 2011-03-18 at 00:36:44.
 */
class ObserableObjectTest extends \PHPUnit_Framework_TestCase
{

	public function testEventFail()
	{
		$this->setExpectedException('\\InvalidArgumentException');
		$obj = new TestObservableObject();

		$obj->onTest[] = new Delegate($obj, 'TheTestEventListenerFail');
		$this->assertFalse($obj->HasFired());
		$obj->FireOnTest();
		$this->assertTrue($obj->HasFired());
	}

	public function testEvent()
	{
		$obj = new TestObservableObject();
		$obj->onTest[] = new Delegate($obj, 'TheTestEventListener');
		$this->assertFalse($obj->HasFired());
		$obj->FireOnTest();
		$this->assertTrue($obj->HasFired());
	}

}

/**
 * @property Event $onTest
 */
class TestObservableObject extends ObserableObject
{
	const onTest = 'onTest';

	private $fired = false;

	public function __construct()
	{
		$this->RegisterEvent(new Event(self::onTest));
	}

	public function FireOnTest()
	{
		$this->onTest->Fire($this, new EventArguments());
	}

	private function TheTestEventListenerFail(TestObservableObject $object, EventArguments $args)
	{
		$this->fired = true;
	}

	/**
	 * @EventAttribute
	 * @param TestObservableObject $object
	 * @param EventArguments $args
	 */
	private function TheTestEventListener(TestObservableObject $object, EventArguments $args)
	{
		$this->fired = true;
	}

	public function HasFired()
	{
		return $this->fired;
	}

}

?>
