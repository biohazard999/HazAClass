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

namespace HazAClass\System;

class Object implements IObject
{

	public static $classname = __CLASS__;
	/**
	 * @var Type
	 */
	private $type;

	public function GetHash()
	{
		return spl_object_hash($this);
	}

	public function ToString()
	{
		return static::$classname;
	}

	final public function __toString()
	{
		return $this->ToString();
	}

	public function GetType()
	{
		if($this->type === null)
			$this->type = new Type($this);
		return $this->type;
	}

	public function GetClassName()
	{
		return get_class($this);
	}

}

?>
