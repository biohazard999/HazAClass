<?php

/** * *******************************************************************************************************$
 * $Id:: SummonTypeAttribute.php 15 2010-11-08 00:48:00Z manuelgrundner                                     $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-08 01:48:00 +0100 (Mo, 08 Nov 2010)                                           $
 * $LastChangedRevision:: 15                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/SummonTypeAttribute.php  $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

use HazAClass\core\attributes\Attribute;

class SummonTypeAttribute extends Attribute
{

	public static $classname = __CLASS__;
	private $summonType;

	public function __construct($summonType)
	{
		$this->summonType = $summonType;
	}

	public function getSummonType()
	{
		return $this->summonType;
	}

}

?>
