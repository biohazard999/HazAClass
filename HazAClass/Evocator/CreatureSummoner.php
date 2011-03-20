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

use HazAClass\core\reflection\ReflectionClass;
use HazAClass\utils\ReflectionUtil;
use HazAClass\core\reflection\ReflectionMethod;
use HazAClass\core\reflection\ReflectionProperty;

class CreatureSummoner
{

	public static $classname = __CLASS__;
	/**
	 * @var string
	 */
	private $creatureClassname;
	/**
	 * @var ReflectionClass
	 */
	private $creatureReflection;
	/**
	 * @var Evocator
	 */
	private $evocator;

	public function __construct($creatureClassName, Evocator $evocator)
	{
		$this->evocator = $evocator;
		$this->creatureClassname = $creatureClassName;
		$this->creatureReflection = ReflectionUtil::getReflectionClass($creatureClassName);
	}

	public function summon()
	{
		$creature = $this->summonCreature();
		$this->summonMethods($creature);
		$this->summonProperties($creature);
		$this->reviveCreature($creature);
		return $creature;
	}

	public function enchant($creature)
	{
		$this->summonMethods($creature);
		$this->summonProperties($creature);
		$this->enchantedCreature($creature);
		return $creature;
	}

	private function summonCreature()
	{
		$constructor = $this->creatureReflection->getConstructor(); /* @var $constructor ReflectionMethod */

		if($constructor === null)
			return new $this->creatureClassname;

		return $this->creatureReflection->newInstanceArgs($this->getArguments($constructor));
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
					$arguments[$param->getPosition()] = $this->evocator->summon($paramReflectionClass->getName());
				}
				catch(AbstractEvocatorException $ex)
				{
					if($param->allowsNull())
						$arguments[$param->getPosition()] = null;
					else
						throw new SummonException(sprintf(SummonException::COULD_NOT_SUMMON_PARAM, $param->getClass(), $paramReflectionClass->getName(), $this->creatureClassname));
				}
			}
			else
				$arguments[$param->getPosition()] = $param->getDefaultValue();
		}
		return $arguments;
	}

	private function summonMethods($creature)
	{
		foreach($this->creatureReflection->getMethods() as $method) /* @var $method ReflectionMethod */
		{
			if($method->hasAttribute(SummonAttribute::$classname))
			{
				$summonAttr = $method->getAttribute(SummonAttribute::$classname); /* @var $summonAttr SummonAttribute */
				if($summonAttr->doSummon())
				{
					try
					{
						if($method->isProtected() || $method->isPrivate())
						{
							$method->setAccessible(true);
							trigger_error('You should not summon private or protected methods via Evocator. Method: '.$method->getName(), E_WARNING);
						}

						$arguments = $this->getArguments($method);
						$method->invokeArgs($creature, $arguments);
					}
					catch(AbstractEvocatorException $ex)
					{
						if(!$summonAttr->isOptional())
							throw $ex;
					}
				}
			}
		}
	}

	private function summonProperties($creature)
	{
		foreach($this->creatureReflection->getProperties() as $property) /* @var $property ReflectionProperty */
		{
			if($property->hasAttribute(SummonAttribute::$classname))
			{
				$summonAttr = $property->getAttribute(SummonAttribute::$classname); /* @var $summonAttr SummonAttribute */
				if($summonAttr->doSummon())
				{
					if(!$property->hasAttribute(SummonTypeAttribute::$classname))
						throw new SummonException(sprintf(SummonException::PROPERTY_SUMMON_DOES_NOT_HAVE_SUMMON_TYPE_ATTRIBUTE, $this->creatureClassname, $property->getName()));

					try
					{
						if($property->isProtected() || $property->isPrivate())
						{
							$property->setAccessible(true);
							trigger_error('You should not summon private or protected properties via Evocator. Property: '.$property->getName(), E_WARNING);
						}


						$summonTypeAttribute = $property->getAttribute(SummonTypeAttribute::$classname); /* @var $summonTypeAttribute SummonTypeAttribute */
						$property->setValue($creature, $this->evocator->summon($summonTypeAttribute->getSummonType()));
					}
					catch(\Exception $ex)
					{
						if(!$summonAttr->isOptional())
							throw $ex;
					}
				}
			}
		}
	}

	private function reviveCreature($creature)
	{
		if($this->creatureReflection->hasAttribute(RevivedAttribute::$classname))
		{
			$revivedAttribute = $this->creatureReflection->getAttribute(RevivedAttribute::$classname); /* @var $revivedAttribute RevivedAttribute */
			$revivedMethodName = $revivedAttribute->getRevidedMethod();
			try
			{
				$method = $this->creatureReflection->getMethod($revivedMethodName);
			}
			catch(\Exception $ex)
			{
				throw new SummonException(sprintf(SummonException::REVIVED_METHOD_DOES_NOT_EXIST, $revivedMethodName, $this->creatureClassname));
			}
			if($method->isPrivate() || $method->isProtected())
			{
				$method->setAccessible(true);
				$method->invoke($creature);
				trigger_error('You should not summon private or protected revive-method via Evocator. Revive-Method: '.$method->getName(), E_WARNING);
			}
			else
				$creature->$revivedMethodName();
		}
	}

	private function enchantedCreature($creature)
	{
		if($this->creatureReflection->hasAttribute(EnchantedAttribute::$classname))
		{
			$enchantAttribute = $this->creatureReflection->getAttribute(EnchantedAttribute::$classname); /* @var $enchantAttribute EnchantedAttribute */
			$enchantMethodName = $enchantAttribute->getEnchantedMethod();
			try
			{
				$method = $this->creatureReflection->getMethod($enchantMethodName);
			}
			catch(\Exception $ex)
			{
				throw new SummonException(sprintf(SummonException::ENCHANT_METHOD_DOES_NOT_EXIST, $enchantMethodName, $this->creatureClassname));
			}
			if($method->isPrivate() || $method->isProtected())
			{
				$method->setAccessible(true);
				$method->invoke($creature);
				trigger_error('You should not enchant private or protected enchant-method via Evocator. Enchant-Method: '.$method->getName(), E_WARNING);
			}
			else
				$creature->$enchantMethodName();
		}
	}
}

?>
