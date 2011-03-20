<?php

/** * *******************************************************************************************************$
 * $Id:: Spell.php 23 2010-11-09 16:49:23Z manuelgrundner                                                   $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/Spell.php                $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

use HazAClass\Evocator\Domination\IDominator;

class Spell
{

	public static $classname = __CLASS__;
	/**
	 * @var iLifetimeManager
	 */
	private $dominator;
	private $name;
	private $type;
	private $creatureClassname;

	public function __construct($type, $creatureClassname, IDominator $dominator, $name = null)
	{
		$this->type = $type;
		$this->creatureClassname = $creatureClassname;
		$this->dominator = $dominator;
		$this->name = $name;

		$this->dominator->setCreatureClassname($creatureClassname);

	}

	public function GetDominator()
	{
		return $this->dominator;
	}

	public function SummonCreature()
	{
		return $this->dominator->dominateCreature();
	}

	public function GetName()
	{
		return $this->name;
	}

	public function getType()
	{
		return $this->type;
	}

}

?>
