<?php

/** * *******************************************************************************************************$
 * $Id:: AbstractDominator.php 23 2010-11-09 16:49:23Z manuelgrundner                                       $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/domination/AbstractDomin#$
 * ********************************************************************************************************* */

namespace HazAClass\Evocator\domination;

use HazAClass\Evocator\Evocator;
use HazAClass\Evocator\CreatureSummoner;

abstract class AbstractDominator implements iDominator
{

	public static $classname = __CLASS__;
	protected $evocator;
	protected $creature;
	protected $creatureName;
	protected $creatureClassname;
	private $summoner;

	public function setCreature($creatureName, $creature)
	{
		$this->setCreatureName($creatureName);
		$this->creature = $creature;
	}

	public function setCreatureClassname($creatureClassname)
	{
		$this->creatureClassname = $creatureClassname;
	}

	public function setCreatureName($creatureName)
	{
		$this->creatureName = $creatureName;
	}

	public function setEvocator(Evocator $evocator)
	{
		$this->evocator = $evocator;
	}

	/**
	 * @return CreatureSummoner
	 */
	public function getSummoner()
	{
		if($this->summoner === null)
			$this->summoner = new CreatureSummoner($this->creatureClassname, $this->evocator);
		return $this->summoner;
	}
}

?>
