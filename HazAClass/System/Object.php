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

include_once 'IObject.php';

abstract class Object implements IObject
{

	public static $classname = __CLASS__;

	public function GetHash()
	{
		return spl_object_hash($this);
	}

	public function ToString()
	{
		return $this->GetClassName().' ('.$this->GetHash().')';
	}

	final public function __toString()
	{
		try
		{
			return $this->ToString();
		}
		catch(\Exception $e)
		{
			return $e->getMessage();
		}
	}

	/**
	 * @return Type
	 */
	final public function GetType()
	{
		return TypeManager::Instance()->GetType($this->GetClassName());
	}

	final public function GetClassName()
	{
		return get_class($this);
	}

	final public static function ReferenceEqualsStatic(IObject $objectA, IObject $objectB)
	{
		return $objectA === $objectB;
	}

	public function ReferenceEquals(IObject $obj)
	{
		return $this === $obj;
	}

}

?>
