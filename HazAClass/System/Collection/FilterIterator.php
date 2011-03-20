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

class FilterIterator extends \FilterIterator
{

	public static $classname = __CLASS__;
	/**
	 * @var IFilter
	 */
	private $filter;

	public function __construct(\Iterator $iterator, IFilter $filter = null)
	{
		parent::__construct($iterator);
		if($filter === null)
			$filter = new TypeFilter(typeof(Object::$classname));
		$this->filter = $filter;
	}

	public function accept()
	{
		$obj = $this->getInnerIterator()->current();
		return $this->filter->Accept($obj);
	}

}

?>
