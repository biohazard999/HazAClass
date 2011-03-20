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

namespace HazAClass\Evocator\Domination;

use HazAClass\Evocator\Evocator;
use HazAClass\Evocator\CreatureSummoner;
use HazAClass\System\Type;
use HazAClass\System\Object;

abstract class AbstractDominator implements IDominator
{

	public static $classname = __CLASS__;
	/**
	 * @var Evocator
	 */
	protected $evocator;
	/**
	 * @var Object
	 */
	protected $creature;
	/**
	 * @var Type
	 */
	protected $creatureType;
	private $summoner;

	public function SetCreatureType(Type $creatureType)
	{
		$this->creatureType = $creatureType;
	}

	public function SetEvocator(Evocator $evocator)
	{
		$this->evocator = $evocator;
	}

	public function SetCreature(Object $creature)
	{
		$this->creature = $creature;
	}

	/**
	 * @return CreatureSummoner
	 */
	protected function GetSummoner()
	{
		if($this->summoner === null)
			$this->summoner = new CreatureSummoner($this->creatureType, $this->evocator);
		return $this->summoner;
	}

}

?>
