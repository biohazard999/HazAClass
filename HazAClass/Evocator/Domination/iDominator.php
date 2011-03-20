<?php

/** * *******************************************************************************************************$
 * $Id:: iDominator.php 23 2010-11-09 16:49:23Z manuelgrundner                                              $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/domination/iDominator.ph#$
 * ********************************************************************************************************* */

namespace HazAClass\Evocator\domination;

use HazAClass\Evocator\Evocator;

interface iDominator
{
	/**
	 * @return mixed
	 */
	public function dominateCreature();

	public function setCreature($creatureName, $creature);

	public function setCreatureName($creatureName);

	public function setCreatureClassname($creatureClassname);

	public function setEvocator(Evocator $evocator);

	/**
	 * @return CreatureSummoner
	 */
	public function getSummoner();
}