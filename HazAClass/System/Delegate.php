<?php

namespace HazAClass\System;

final class Delegate extends Object
{

	private $object;
	private $method;

	public function __construct(Object $object, $method)
	{
		$this->object = $object;
		$this->method = $method;
	}

	public function Invoke(ObserableObject $object, EventArguments $args)
	{
		$method = $object->GetType()->GetReflectionClass()->getMethod($this->method);
		if(!$method->HasAttribute(EventAttribute::$classname))
			throw new \InvalidArgumentException('Given Delegate does not have the EventAttribute: '.$object->GetType()->GetFullName().'->'.$this->method);

		$method->setAccessible(true);
		$method->invokeArgs($object, array($object, $args));
	}

}

?>
