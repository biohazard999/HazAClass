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

namespace HazAClass;

class HashMap implements IList
{

	public static $classname = __CLASS__;
	private $keyTypes;
	private $typeOfElements;
	private $innerDict = array();

	public function __construct(Type $keyType, Type $elementType)
	{
		$this->keyTypes = $keyType;
		$this->typeOfElements = $elementType;
	}

	public function AddArray(array $array)
	{
		foreach($array as $key => $value)
			$this->AddElement($key, $value);
	}

	public function AddElement($element)
	{
		
	}

	public function AddIterator(\Iterator $iterator)
	{

	}

	public function AddRange($mixed)
	{
		
	}

	public function ElementExists($element)
	{

	}

	public function FlushElements()
	{
		
	}

	public function GetFirstElement()
	{

	}

	public function GetKeys()
	{
		
	}

	public function GetLastElement()
	{

	}

	public function IndexExists($index)
	{
		
	}

	public function IndexOf($element)
	{

	}

	public function InsertElement($index, $element)
	{
		
	}

	public function Remove($element)
	{

	}

	public function RemoveAt($index)
	{
		
	}

	public function ToArray()
	{

	}

	public function count()
	{
		
	}

	public function current()
	{

	}

	public function key()
	{
		
	}

	public function next()
	{

	}

	public function offsetExists($offset)
	{
		
	}

	public function offsetGet($offset)
	{

	}

	public function offsetSet($offset, $value)
	{
		
	}

	public function offsetUnset($offset)
	{

	}

	public function rewind()
	{
		
	}

	public function valid()
	{

	}

}

?>