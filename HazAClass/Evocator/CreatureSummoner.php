<?php
/** * *******************************************************************************************************$
 * $Id:: CreatureSummoner.php 23 2010-11-09 16:49:23Z manuelgrundner                                        $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/CreatureSummoner.php     $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

use HazAClass\System\Object;
use HazAClass\System\Type;
use HazAClass\System\Reflection\ReflectionMethod;

class CreatureSummoner
{

	public static $classname = __CLASS__;
	/**
	 * @var Type
	 */
	private $creatureType;
	/**
	 * @var Evocator
	 */
	private $evocator;

	public function __construct(Type $creatureType, Evocator $evocator)
	{
		$this->evocator = $evocator;
		$this->creatureType = $creatureType;
	}

	public function Summon()
	{
		$creature = $this->summonCreature();
		$this->summonProperties($creature);
		$this->summonMethods($creature);
		$this->reviveCreature($creature);
		return $creature;
	}

	public function Enchant(Object $creature)
	{
		$this->summonMethods($creature);
		$this->summonProperties($creature);
		$this->enchantedCreature($creature);
		return $creature;
	}

	/**
	 * @return Object
	 */
	private function summonCreature()
	{
		$constructor = $this->creatureType->GetReflectionClass()->getConstructor();

		if($constructor === null)
		{
			$name = $this->creatureType->GetFullName();
			return new $name;
		}

		return $this->creatureType->GetReflectionClass()->newInstanceArgs($this->getArguments($constructor));
	}

	private function getArguments(ReflectionMethod $method)
	{
		$arguments = array();
		foreach($method->getParameters() as $param) /* @var $param ReflectionParameter */
		{
			if($param->getClass() === null && !$param->isOptional())
				throw new SummonException(SummonException::SCALAR_TYPES_COULD_NOT_BE_INJECTED);

			if($param->getClass() !== null)
			{
				$paramReflectionClass = $param->getClass();

				try
				{
					$arguments[$param->getPosition()] = $this->evocator->Summon(typeof($paramReflectionClass->getName()));
				}
				catch(AbstractEvocatorException $ex)
				{
					if($param->allowsNull())
						$arguments[$param->getPosition()] = null;
					else
						throw new SummonException(sprintf(SummonException::COULD_NOT_SUMMON_PARAM, $param->getClass(), $paramReflectionClass->getName(), $this->creatureType->GetFullName()));
				}
			}
			else
				$arguments[$param->getPosition()] = $param->getDefaultValue();
		}
		return $arguments;
	}

	private function summonMethods(Object $creature)
	{
		foreach($creature->GetType()->GetReflectionClass()->getMethods() as $method) /* @var $method ReflectionMethod */
		{
			if($method->HasAttribute(SummonMethodAttribute::$classname))
			{
				$method->setAccessible(true);
				$arguments = $this->getArguments($method);
				$method->invokeArgs($creature, $arguments);
			}
		}
	}

	private function summonProperties(Object $creature)
	{
		foreach($creature->GetType()->GetReflectionClass()->getProperties() as $property) /* @var $property ReflectionProperty */
		{
			if($property->HasAttribute(SummonAttribute::$classname))
			{
				$summonAttr = $property->getAttribute(SummonAttribute::$classname); /* @var $summonAttr SummonAttribute */
				
				try
				{
					$property->setAccessible(true);
					$property->setValue($creature, $this->evocator->Summon($summonAttr->GetSpellType(), $summonAttr->GetName()));
				}
				catch(\Exception $ex)
				{
					if(!$summonAttr->IsOptional())
						throw $ex;
				}
			}
		}
	}

	private function reviveCreature(Object $creature)
	{
		$refClass = $creature->GetType()->GetReflectionClass();
		if($refClass->HasAttribute(RevivedAttribute::$classname))
		{
			$revivedAttribute = $refClass->GetAttribute(RevivedAttribute::$classname); /* @var $revivedAttribute RevivedAttribute */
			$revivedMethodName = $revivedAttribute->GetRevidedMethod();

			try
			{
				$method = $refClass->getMethod($revivedMethodName);
			}
			catch(\Exception $ex)
			{
				throw new SummonException(sprintf(SummonException::REVIVED_METHOD_DOES_NOT_EXIST, $revivedMethodName, $this->creatureType->GetFullName()));
			}

			$method->setAccessible(true);
			$method->invoke($creature);
		}
	}

	private function enchantedCreature(Object $creature)
	{
		$refClass = $creature->GetType()->GetReflectionClass();
		if($refClass->HasAttribute(EnchantedAttribute::$classname))
		{
			$enchantAttribute = $refClass->GetAttribute(EnchantedAttribute::$classname); /* @var $enchantAttribute EnchantedAttribute */
			$enchantMethodName = $enchantAttribute->GetEnchantedMethod();
			try
			{
				$method = $refClass->getMethod($enchantMethodName);
			}
			catch(\Exception $ex)
			{
				throw new SummonException(sprintf(SummonException::ENCHANT_METHOD_DOES_NOT_EXIST, $enchantMethodName, $this->creatureType->GetFullName()));
			}

			$method->setAccessible(true);
			$method->invoke($creature);
		}
	}

}

?>
