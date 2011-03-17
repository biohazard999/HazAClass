<?php

namespace HazAClass\System;

use HazAClass\System\Collection\Generic\GenericList;

abstract class ObserableObject extends Object
{
	private $eventList;

	protected function RegisterEvent(Event $event)
	{
		if($this->eventList === null)
			$this->eventList = new GenericList(Event::$classname);
		$this->eventList[$event->GetName()] = $event;
	}

	/**
	 * @param string $name
	 * @return Event
	 */
	final public function __get($name)
	{
		return $this->eventList[$name];
	}


}

?>
