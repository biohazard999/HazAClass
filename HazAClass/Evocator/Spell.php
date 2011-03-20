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
use HazAClass\System\Type;
use HazAClass\System\Object;

final class Spell extends Object
{

	public static $classname = __CLASS__;
	/**
	 * @var IDominator
	 */
	private $dominator;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var Type
	 */
	private $spellType;
	/**
	 * @var Type
	 */
	private $creatureType;

	public function __construct(Type $spellType, Type $creatureType, IDominator $dominator, $name = null)
	{
		$this->spellType = $spellType;
		$this->creatureType = $creatureType;
		$this->dominator = $dominator;
		$this->name = $name;

		$this->dominator->SetCreatureType($creatureType);
	}

	/**
	 * @return IDominator
	 */
	public function GetDominator()
	{
		return $this->dominator;
	}

	public function SummonCreature()
	{
		return $this->dominator->DominateCreature();
	}

	public function GetName()
	{
		return $this->name;
	}

	/**
	 * @return Type
	 */
	public function GetSpellType()
	{
		return $this->spellType;
	}

	/**
	 * @return Type
	 */
	public function GetCreatureType()
	{
		return $this->creatureType;
	}

}

?>
