<?php

/** * *******************************************************************************************************$
 * $Id:: AttributeInheritance.php 48 2010-11-28 09:03:29Z manuelgrundner                                    $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-28 10:03:29 +0100 (So, 28 Nov 2010)                                           $
 * $LastChangedRevision:: 48                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeInherita#$
 * ********************************************************************************************************* */

namespace HazAClass\System;

class AttributeInheritance extends Enum
{

	public static $classname = __CLASS__;

	public static function Inherited()
	{
		return self::GetInstance(__FUNCTION__);
	}

	public static function NotInherited()
	{
		return self::GetInstance(__FUNCTION__);
	}

}

?>
