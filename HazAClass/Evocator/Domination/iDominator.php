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

namespace HazAClass\Evocator\Domination;

use HazAClass\Evocator\Evocator;
use HazAClass\System\Type;
use HazAClass\System\Object;

interface IDominator
{
	/**
	 * @return mixed
	 */
	public function DominateCreature();

	public function SetCreatureType(Type $creatureType);
	
	public function SetEvocator(Evocator $evocator);
	
	public function SetCreature(Object $creature);
}