<?php
/** * *******************************************************************************************************$
 * $Id:: DocumentHeadRenderer.php 199 2009-09-30 19:57:12Z manuelgrundner                                   $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2009-09-30 21:57:12 +0200 (Mi, 30 Sep 2009)                                           $
 * $LastChangedRevision:: 199                                                                               $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://jackonrock.dyndns.org:81/svn/HazAClassLite/branches/HazAClass53/framework/controls/doc#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Collection\Generic;

use HazAClass\System\Collection\IList;
use HazAClass\System\Object;
use HazAClass\System\Collection\ArrayList;

class GenericList extends Object implements IList
{

	public static $classname = __CLASS__;
	private $typeofElements;
	/**
	 * @var IList
	 */
	private $innerList;

	public function __construct($type)
	{
		$this->typeofElements = typeof($type);
		$this->innerList = new ArrayList();
	}

	public function IsElementMatching($element)
	{
		return typeof(get_class($element))->IsTypeOf($this->typeofElements);
	}

	private function GuardElementIsTypeOfGeneric($element)
	{
		if(!$this->IsElementMatching($element))
			throw new \InvalidArgumentException('Given Element is not matching the generic Type');
	}

	public function AddArray(array $array)
	{
		foreach($array as $value)
			$this->AddElement($value);
	}

	public function AddElement($element)
	{
		$this->GuardElementIsTypeOfGeneric($element);
		return $this->innerList->AddElement($element);
	}

	public function AddIterator(\Iterator $iterator)
	{
		foreach($iterator as $value)
			$this->AddElement($value);
	}

	public function AddRange($mixed)
	{
		if(is_array($mixed))
			$this->AddArray($mixed);
		elseif($mixed instanceof \Iterator)
			$this->AddIterator($mixed);
		else
			throw new \InvalidArgumentException('Param1 must be an array or a instance of \\Iterator');
	}

	public function ElementExists($element)
	{
		return $this->innerList->ElementExists($element);
	}

	public function FlushElements()
	{
		return $this->innerList->FlushElements();
	}

	public function GetFirstElement()
	{
		return $this->innerList->GetFirstElement();
	}

	public function GetKeys()
	{
		return $this->innerList->GetKeys();
	}

	public function GetLastElement()
	{
		return $this->innerList->GetLastElement();
	}

	public function IndexExists($index)
	{
		return $this->innerList->IndexExists($index);
	}

	public function IndexOf($element)
	{
		return $this->innerList->IndexOf($element);
	}

	public function InsertElement($index, $element)
	{
		return $this->innerList->InsertElement($index, $element);
	}

	public function Remove($element)
	{
		return $this->innerList->Remove($element);
	}

	public function RemoveAt($index)
	{
		return $this->innerList->RemoveAt($index);
	}

	public function ToArray()
	{
		return $this->innerList->ToArray();
	}

	public function count()
	{
		return $this->innerList->count();
	}

	public function current()
	{
		return $this->innerList->current();
	}

	public function key()
	{
		return $this->innerList->key();
	}

	public function next()
	{
		return $this->innerList->next();
	}

	public function offsetExists($offset)
	{
		return $this->innerList->offsetExists($offset);
	}

	public function offsetGet($offset)
	{
		return $this->innerList->offsetGet($offset);
	}

	public function offsetSet($offset, $value)
	{
		$this->GuardElementIsTypeOfGeneric($value);
		return $this->innerList->offsetSet($offset, $value);
	}

	public function offsetUnset($offset)
	{
		return $this->innerList->offsetUnset($offset);
	}

	public function rewind()
	{
		return $this->innerList->rewind();
	}

	public function valid()
	{
		return $this->innerList->valid();
	}

}

?>
