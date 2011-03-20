<?php

/** * *******************************************************************************************************$
 * $Id:: EvocatorDominator.php 23 2010-11-09 16:49:23Z manuelgrundner                                       $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-09 17:49:23 +0100 (Di, 09 Nov 2010)                                           $
 * $LastChangedRevision:: 23                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/domination/EvocatorDomin#$
 * ********************************************************************************************************* */

namespace HazAClass\Evocator\domination;


/**
 * This Dominator provides a lifetime of objects over the whole Evocator lifetime.
 * Each call of summonCreature will give you one instance per Evocator.
 */
class EvocatorDominator extends AbstractDominator
{

	public static $classname = __CLASS__;

	public function dominateCreature()
	{
		if($this->creature === null)
			$this->creature = $this->getSummoner()->summon();
		
		return $this->creature;
	}

}

?>
