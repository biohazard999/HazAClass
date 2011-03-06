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

use HazAClass\System\IArrayCastAble;
use HazAClass\System\Object;

class ArrayList extends Object implements IList
{

	public static $classname = __CLASS__;
	private $innerArray = array();

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
		return !(current($this->innerArray) === false);
	}

	public function ToArray()
	{
		return iterator_to_array($this);
	}

}

?>
