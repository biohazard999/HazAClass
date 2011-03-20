<?php

/** * *******************************************************************************************************$
 * $Id:: ImmortalDominator.php 48 2010-11-28 09:03:29Z manuelgrundner                                       $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/domination/ImmortalDomin#$
 * ********************************************************************************************************* */

namespace HazAClass\Evocator\domination;

use HazAClass\Evocator\Evocator;
use HazAClass\Evocator\CreatureSummoner;

/**
 * This Dominator provides a lifetime of objects over all the whole Evocator-Hierachie.
 * Each call of summonCreature will give you the same instance, independent from the Evocator called.
 */
class ImmortalDominator extends AbstractDominator
{

	public static $classname = __CLASS__;
	private static $creaturePool = array();

	public function setCreature($creatureName, $creature)
	{
		parent::setCreature($creatureName, $creature);
		self::$creaturePool[$this->getGrandEvocatorIdentity()][$creatureName] = $creature;
	}

	public function dominateCreature()
	{
		if(!isset(self::$creaturePool[$this->getGrandEvocatorIdentity()][$this->creatureName]))
			$this->setCreature($this->creatureName, $this->getSummoner()->summon());

		return $this->creature;
	}

	public function setCreatureClassname($creatureClassname)
	{
		$this->creatureClassname = $creatureClassname;
	}

	protected function getGrandEvocatorIdentity()
	{
		return $this->evocator->getGrandEvocator()->getIdentity();
	}

}

?>
