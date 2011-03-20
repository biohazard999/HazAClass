<?php

namespace HazAClass\System;

use HazAClass\System\Collection\Generic\GenericList;

final class Event extends Object implements \ArrayAccess
{

	public static $classname = __CLASS__;
	private $eventName;
	private $eventArgumentName;
	/**
	 * @var GenericList
	 */
	private $delegates;

	public function __construct($eventName, $eventArgumentName = null)
	{
		$this->eventName = $eventName;
		if($eventArgumentName === null)
			$eventArgumentName = EventArguments::$classname;
		$this->eventArgumentName = $eventArgumentName;

		$this->delegates = new GenericList(Delegate::$classname);
	}

	public function GetName()
	{
		return $this->eventName;
	}

	public function AddDelegate(Delegate $delegate)
	{
		$this->delegates[] = $delegate;
	}

	public function RemoveDelegate(Delegate $delegate)
	{
		$this->delegates->Remove($delegate);
	}

	public function Fire(ObserableObject $obObject, EventArguments $eventArguments)
	{
		if(!$eventArguments->GetType()->IsTypeOf(typeof($this->eventArgumentName)))
			throw new \InvalidArgumentException('Given Argument is not type of '.$this->eventArgumentName);

		foreach($this->delegates as $delegate)
			$delegate->Invoke($obObject, $eventArguments);
	}

	public function offsetExists($offset)
	{
		return $this->delegates->offsetExists($offset);
	}

	public function offsetGet($offset)
	{
		return $this->delegates->offsetGet($offset);
	}

	public function offsetSet($offset, $value)
	{
		if($offset === '-')
			$this->RemoveDelegate($value);
		else
			$this->AddDelegate($value);
	}

	public function offsetUnset($offset)
	{
		return $this->delegates->offsetUnset($offset);
	}

}

?>
