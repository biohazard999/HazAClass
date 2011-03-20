<?php
/** ********************************************************************************************************$
 * $Id:: AutoSummonException.php 14 2010-11-07 22:52:40Z manuelgrundner                                     $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 *********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 ******************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-07 23:52:40 +0100 (So, 07 Nov 2010)                                           $
 * $LastChangedRevision:: 14                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/AutoSummonException.php  $
 ***********************************************************************************************************/

namespace HazAClass\Evocator;

class AutoSummonException extends AbstractEvocatorException
{
	public static $classname = __CLASS__;

	const INTERFACE_COULD_NOT_BE_AUTO_SUMMOND = 'An Interface could not be autosummond. Are you missing a Spell-Learn?';
}

?>
