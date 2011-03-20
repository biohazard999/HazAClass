<?php

/** * *******************************************************************************************************$
 * $Id:: SummonException.php 19 2010-11-08 01:51:07Z manuelgrundner                                         $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-08 02:51:07 +0100 (Mo, 08 Nov 2010)                                           $
 * $LastChangedRevision:: 19                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/SummonException.php      $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

class SummonException extends AbstractEvocatorException
{

	public static $classname = __CLASS__;

	const SCALAR_TYPES_COULD_NOT_BE_INJECTED = 'Scalar types could not be injected';

	const COULD_NOT_SUMMON_PARAM = 'Couldn\'t summon param with name %s and type %s in creature %s. Are you missing a spell registration?';
	const PROPERTY_SUMMON_DOES_NOT_HAVE_SUMMON_TYPE_ATTRIBUTE = 'Property with SummonAttribute does not have SummonTypeAttribute. Given Type: %s. Given Property: %s';

	const REVIVED_METHOD_DOES_NOT_EXIST = 'Revived method with name (%s) does not exist in type: %s.';
	const ENCHANT_METHOD_DOES_NOT_EXIST = 'Enchant method with name (%s) does not exist in type: %s.';
	const COULD_NOT_ENCHANT_CREATUE = 'Couldn\'t enchant creatue cause it is not an object';
}

?>
