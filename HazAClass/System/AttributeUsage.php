<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeUsage.php 6 2010-11-07 15:18:15Z manuelgrundner                                           $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-07 16:18:15 +0100 (So, 07 Nov 2010)                                           $
 * $LastChangedRevision:: 6                                                                                 $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeUsage.ph#$
 * ********************************************************************************************************* */

namespace HazAClass\System;

class AttributeUsage extends Enum
{

	public static $classname = __CLASS__;

	public static function OnClass()
	{
		return self::GetInstance(__FUNCTION__);
	}

	public static function OnMethod()
	{
		return self::GetInstance(__FUNCTION__);
	}

	public static function OnProperty()
	{
		return self::GetInstance(__FUNCTION__);
	}

	public static function OnAny()
	{
		return self::GetInstance(__FUNCTION__);
	}

}

?>
