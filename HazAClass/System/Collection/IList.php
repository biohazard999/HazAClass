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

interface IList extends \ArrayAccess, \Countable, \Iterator, IArrayCastAble
{
	const IList = __CLASS__;

	/**
	 * @return mixed The first item of the list
	 */
	public function GetFirstElement();

	/**
	 * @return mixed The last item of the list
	 */
	public function GetLastElement();

	/**
	 * @return IList The keys of the list
	 */
	public function GetKeys();

	/**
	 * Flushes all elements in the list
	 * @return void
	 */
	public function FlushElements();

	/**
	 * Adds an element to the list
	 * @param mixed $element The element to add
	 * @return void
	 */
	public function AddElement($element);
	
	/**
	 * Adds an element to the list
	 * @param mixed $index The indexof the element
	 * @param mixed $element The element to add
	 * @return void
	 */
	public function InsertElement($index, $element);
	
	/**
	 * @param mixed The element
	 * @return mixed The index of the element
	 */
	public function IndexOf($element);
	
	/**
	 * @param mixed The element to remove
	 */
	public function Remove($element);
	
	/**
	 * @param mixed The index of the element to remove
	 */
	public function RemoveAt($index);

	/**
	 * @param \Iterator $iterator The iterator to add to the list
	 * @return void
	 */
	public function AddIterator(\Iterator $iterator);

	/**
	 * @param array $array The iterator to add to the list
	 * @return void
	 */
	public function AddArray(array $array);
	
	/**
	 * @param mixed $mixed Adds an Array or an Iterator to the List
	 * @return void
	 */
	public function AddRange($mixed);
	
	public function IndexExists($index);
	
	public function ElementExists($element);
}

?>
