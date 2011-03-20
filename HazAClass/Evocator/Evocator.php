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

use HazAClass\core\collections\Map;
use HazAClass\Evocator\domination\iDominator;
use HazAClass\utils\ReflectionUtil;
use HazAClass\utils\StringUtil;
use HazAClass\Evocator\domination\TemporalDominator;
use HazAClass\Evocator\domination\EvocatorDominator;

class Evocator
{

	public static $classname = __CLASS__;
	/**
	 * @var Collection
	 */
	private $noviceEvocators;
	/**
	 * @var Evocator
	 */
	private $masterEvocator;
	/**
	 * @var Map
	 */
	private $spells;
	/**
	 * @var string
	 */
	private $identity;

	public function __construct(Evocator $parentEvocator = null)
	{
		$this->masterEvocator = $parentEvocator;
		$this->spells = new Map(Spell::$classname);
	}

	/**
	 *
	 * @param string $classnameOrInterface
	 * @return mixed
	 */
	public function summon($classnameOrInterface, $name = null)
	{
		if($this->hasSpell($classnameOrInterface, $name))
			return $this->getSpell($classnameOrInterface, $name)->summonCreature();
			
		return $this->autoSummon($classnameOrInterface);
	}

	/**
	 * @param string $classnameOrInterface
	 * @param string $name
	 * @return Spell
	 */
	private function getSpell($classnameOrInterface, $name)
	{
		return $this->spells[$this->createSpellName($classnameOrInterface, $name)];
	}

	private function autoSummon($classname)
	{
		if(interface_exists($classname))
			throw new AutoSummonException(AutoSummonException::INTERFACE_COULD_NOT_BE_AUTO_SUMMOND);

		$summoner = new CreatureSummoner($classname, $this);
		return $summoner->summon();
	}

	/**
	 *
	 * @param string $creature
	 * @return mixed
	 */
	public function enchant($creature)
	{
		if(!is_object($creature))
			throw new SummonException(SummonException::COULD_NOT_ENCHANT_CREATUE);
		$summoner = new CreatureSummoner(get_class($creature), $this);
		return $summoner->enchant($creature);
	}

	public function hasSpell($classnameOrInterface, $name = null)
	{
		return $this->spells->hasIndex($this->createSpellName($classnameOrInterface, $name));
	}

	/**
	 * @param string $classnameOrInterface
	 * @param string $type
	 * @param iLifetimeManager $dominator
	 * @param string $name
	 */
	public function learnSpell($classnameOrInterface, $type, $name = null, iDominator $dominator = null)
	{
		$this->checkClassnameOrInterface($classnameOrInterface);
		$this->checkType($classnameOrInterface, $type);

		if($dominator === null)
			$dominator = new TemporalDominator();


		$spellName = $this->createSpellName($classnameOrInterface, $name);
		$dominator->setEvocator($this);


		$spell = new Spell($classnameOrInterface, $type, $dominator, $spellName);
		$this->spells[$spellName] = $spell;

		return $this;
	}

	private function checkClassnameOrInterface($classnameOrInterface)
	{
		if(!is_string($classnameOrInterface) || !ReflectionUtil::classOrInterfaceExists($classnameOrInterface))
			throw new LearnSpellException('Given $classnameOrInterface is not a string or doesn\'t exist, are you missing a string cast?');
	}

	private function checkType($classnameOrInterface, $type)
	{
		if(!is_string($type) || !ReflectionUtil::classOrInterfaceExists($type))
			throw new LearnSpellException('Given $type ('.print_r($type, true).') is not a string or doesn\'t exist, are you missing a string cast? \n If you want to register an object instance use the possessCreature method');


		if(!ReflectionUtil::implementsInterface($type, $classnameOrInterface))
			throw new LearnSpellException('Given $type ('.print_r($type, true).') is not instance of $classnameOrInterface ('.$classnameOrInterface.'), are you missing the interface implementation?');
	}

	private function checkCreature($classnameOrInterface, $creature)
	{
		if(!is_object($creature))
			throw new PossessCreatureException('Given $creature is not an object');

		if(interface_exists($classnameOrInterface) && !ReflectionUtil::implementsInterface($creature, $classnameOrInterface))
			throw new PossessCreatureException('Given $creature is not implementing interface '.$classnameOrInterface);

		if(interface_exists($classnameOrInterface) && !($creature instanceof $classnameOrInterface))
			throw new PossessCreatureException('Given $creature is not type of '.$classnameOrInterface);
	}

	public function possessCreature($classnameOrInterface, $creature, $name = null, iDominator $dominator = null)
	{
		$this->checkClassnameOrInterface($classnameOrInterface);
		$this->checkCreature($classnameOrInterface, $creature);

		if($dominator === null)
			$dominator = new EvocatorDominator();

		$spellName = $this->createSpellName($classnameOrInterface, $name);
		$dominator->setEvocator($this);
		$dominator->setCreature($spellName, $creature);

		$spell = new Spell($classnameOrInterface, get_class($creature), $dominator, $spellName);
		$this->spells[$spellName] = $spell;
		return $this;
	}

	public function forgetSpell($classnameOrInterface, $name = null)
	{
		$this->spells->removeIndex($this->createSpellName($classnameOrInterface, $name));
	}

	public function annihilateSpell($classnameOrInterface, $name = null)
	{
		$this->forgetSpell($classnameOrInterface, $name);
		foreach($this->noviceEvocators as $novice) /* @var $novice Evocator */
			$novice->forgetSpell($classnameOrInterface, $name);
	}

	/**
	 * @param string $classnameOrInterface
	 * @return Map
	 */
	public function summonAll($classnameOrInterface)
	{
		$creatures = new Map($classnameOrInterface);
		foreach($this->spells as $name => $spell)
		{
			if(StringUtil::startsWith($name, $classnameOrInterface.'('))
			{
				$shortName = StringUtil::remove($name, $classnameOrInterface);
				$shortName = StringUtil::remove($shortName, '(');
				$shortName = StringUtil::remove($shortName, ')');
				$creatures[$shortName] = $this->summon($classnameOrInterface, $shortName);
			}
		}
		return $creatures;
	}

	private function createSpellName($classnameOrInterface, $name = null)
	{
		if($name !== null)
			return $classnameOrInterface.'('.$name.')';

		return $classnameOrInterface;
	}

	/**
	 * @return Evocator
	 */
	public function createNoviceEvocator()
	{
		$noviceEvocator = new static($this);
		$this->noviceEvocators[] = $noviceEvocator;
		return $noviceEvocator;
	}

	public function getMasterEvocator()
	{
		return $this->masterEvocator;
	}

	public function isGrandEvocator()
	{
		return $this->masterEvocator === null;
	}

	public function getGrandEvocator()
	{
		if($this->isGrandEvocator())
			return $this;
		return $this->getMasterEvocator()->getGrandEvocator();
	}


	public function getIdentity()
	{
		if($this->identity === null)
			$this->identity = String::Instance()->UUID()->ToString();
		 return $this->identity;
	}


}

?>
