<?php
/** * *******************************************************************************************************$
 * $Id:: Evocator.php 48 2010-11-28 09:03:29Z manuelgrundner                                                $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/Evocator.php             $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

use HazAClass\Evocator\domination\IDominator;
use HazAClass\Evocator\Domination\TemporalDominator;
use HazAClass\Evocator\Domination\EvocatorDominator;
use HazAClass\System\Collection\Generic\GenericList;
use HazAClass\System\Type;
use HazAClass\System\Object;
use HazAClass\System\String;

class Evocator extends Object
{

	public static $classname = __CLASS__;
	/**
	 * @var GenericList
	 */
	private $noviceEvocators;
	/**
	 * @var GenericList
	 */
	private $spells;

	public function __construct()
	{
		$this->spells = new GenericList(Spell::$classname);
	}

	/**
	 * @param string $type
	 * @return Object
	 */
	public function Summon(Type $type, $name = null)
	{
		if($this->HasSpell($type, $name))
			return $this->GetSpell($type, $name)->SummonCreature();

		return $this->AutoSummon($type);
	}

	/**
	 * @param string $type
	 * @param string $name
	 * @return Spell
	 */
	private function GetSpell(Type $type, $name)
	{
		return $this->spells[$this->createSpellName($type, $name)];
	}

	private function AutoSummon(Type $type)
	{
		if($type->IsInterface())
			throw new AutoSummonException(AutoSummonException::INTERFACE_COULD_NOT_BE_AUTO_SUMMOND);

		$summoner = new CreatureSummoner($type, $this);
		return $summoner->Summon();
	}

	/**
	 *
	 * @param string $creature
	 * @return mixed
	 */
	public function Enchant(Object $creature)
	{
		$summoner = new CreatureSummoner($creature->GetType(), $this);
		return $summoner->Enchant($creature);
	}

	public function HasSpell(Type $type, $name = null)
	{
		return $this->spells->IndexExists($this->createSpellName($type, $name));
	}

	/**
	 * @param Type $spellType
	 * @param Type $creatureType
	 * @param string $name
	 * @param IDominator $dominator
	 */
	public function LearnSpell(Type $spellType, Type $creatureType, $name = null, IDominator $dominator = null)
	{
		$this->checkType($spellType, $creatureType);

		if($dominator === null)
			$dominator = new TemporalDominator();


		$spellName = $this->createSpellName($spellType, $name);
		$dominator->SetEvocator($this);


		$spell = new Spell($spellType, $creatureType, $dominator, $spellName);
		$this->spells[$spellName] = $spell;

		return $this;
	}

	private function checkType(Type $type, Type $creatureType)
	{
		if($type->IsInterface() && !$creatureType->ImplementsInterface($type))
			throw new LearnSpellException('Given $creatureType ('.$creatureType.') is not instance of $type ('.$type.'), are you missing the interface implementation?');

		if($type->IsClass() && !$creatureType->IsTypeOf($type))
			throw new LearnSpellException('Given $creatureType ('.$creatureType.') is not instance of $type ('.$type.'), are you missing the interface implementation?');
	}

	public function PossessCreature(Type $type, Object $creature, $name = null, IDominator $dominator = null)
	{
		$this->checkType($type, $creature->GetType());

		if($dominator === null)
			$dominator = new EvocatorDominator();

		$spellName = $this->createSpellName($type, $name);
		$dominator->setEvocator($this);
		$dominator->setCreature($creature);

		$this->spells[$spellName] = new Spell($type, $creature->GetType(), $dominator, $spellName);
		return $this;
	}

	public function ForgetSpell(Type $type, $name = null)
	{
		$this->spells->RemoveAt($this->createSpellName($type, $name));
	}

	public function AnnihilateSpell(Type $type, $name = null)
	{
		$this->ForgetSpell($type, $name);
		foreach($this->noviceEvocators as $novice) /* @var $novice Evocator */
			$novice->ForgetSpell($type, $name);
	}

	/**
	 * @param string $type
	 * @return Map
	 */
	public function SummonAll(Type $type)
	{
		$creatures = new GenericList($type);
		foreach($this->spells as $name => $spell)
		{
			if(String::Instance($name)->StartsWith($type.'('))
			{
				$str = String::Instance($name)
					->Remove($type)
					->Remove('(')
					->Remove(')');

				$creatures[$str->ToString()] = $this->summon($type, $str->ToString());
			}
		}
		return $creatures;
	}

	private function createSpellName(Type $type, $name = null)
	{
		if($name !== null)
			return $type.'('.$name.')';

		return $type->ToString();
	}

	/**
	 * @return Evocator
	 */
	public function CreateNoviceEvocator()
	{
		$noviceEvocator = new static(); /* @var $noviceEvocator Evocator */
		$this->noviceEvocators[] = $noviceEvocator;
		foreach($this->spells as $spell) /* @var $spell Spell */
			$noviceEvocator->LearnSpell($spell->GetType(), $spell->GetCreatureType(), $spell->GetName(), $spell->GetDominator());

		return $noviceEvocator;
	}

}

?>
