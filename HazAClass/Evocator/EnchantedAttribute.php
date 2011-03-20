<?php

/** * *******************************************************************************************************$
 * $Id:: EnchantedAttribute.php 20 2010-11-08 16:19:38Z manuelgrundner                                      $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-08 17:19:38 +0100 (Mo, 08 Nov 2010)                                           $
 * $LastChangedRevision:: 20                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/EnchantedAttribute.php   $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

use HazAClass\System\Attribute;

class EnchantedAttribute extends Attribute
{

	public static $classname = __CLASS__;
	private $enchantedMethod;

	public function __construct($enchantedMethod = 'enchanted')
	{
		$this->enchantedMethod = $enchantedMethod;
	}

	public function GetEnchantedMethod()
	{
		return $this->enchantedMethod;
	}

}

?>
