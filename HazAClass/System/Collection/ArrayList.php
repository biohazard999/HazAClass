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

namespace HazAClass\System\Collection;

use HazAClass\System\Object;

class ArrayList extends Object implements IList
{

	public static $classname = __CLASS__;
	private $innerArray = array();

	public function __construct(array $initArray = array())
	{
		$this->innerArray = $initArray;
	}

	public function count()
	{
		return count($this->innerArray);
	}

	public function offsetExists($offset)
	{
		return array_key_exists($offset, $this->innerArray);
	}

	public function offsetGet($offset)
	{
		return $this->innerArray[$offset];
	}

	public function offsetSet($offset, $value)
	{
		if($offset === null)
			return $this->innerArray[] = $value;
		return $this->innerArray[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->innerArray[$offset]);
	}

	public function current()
	{
		return current($this->innerArray);
	}

	public function key()
	{
		return key($this->innerArray);
	}

	public function next()
	{
		return next($this->innerArray);
	}

	public function rewind()
	{
		return reset($this->innerArray);
	}

	public function valid()
	{
		return!(current($this->innerArray) === false);
	}

	public function ToArray()
	{
		return iterator_to_array($this);
	}

	public function AddArray(array $array)
	{
		foreach($array as $value)
			$this->AddElement($value);
	}

	public function AddElement($element)
	{
		$this->innerArray[] = $element;
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

	public function FlushElements()
	{
		$this->innerArray = array();
	}

	public function GetFirstElement()
	{
		$this->rewind();
		$first = $this->current();

		if($first === false)
			return null;
		return $first;
	}

	public function GetLastElement()
	{
		end($this->innerArray);
		$last = $this->current();
		if($last === false)
			return null;
		return $last;
	}

	public function GetKeys()
	{
		return new ArrayList(array_keys($this->innerArray));
	}

	public function IndexOf($element)
	{
		$result = array_search($element, $this->innerArray, true);

		return $result === false ? null : $result;
	}

	public function InsertElement($index, $element)
	{
		$this->offsetSet($index, $element);
	}

	public function Remove($element)
	{
		$index = $this->IndexOf($element);
		unset($this[$index]);
	}

	public function RemoveAt($index)
	{
		unset($this[$index]);
	}

	public function IndexExists($index)
	{
		return array_key_exists($index, $this->innerArray);
	}

	public function ElementExists($element)
	{
		return in_array($element, $this->innerArray, true);
	}

}

?>
