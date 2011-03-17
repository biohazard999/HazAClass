<?php
/** * *******************************************************************************************************$
 * $Id:: ReflectionClass.php 60 2010-12-11 19:50:29Z manuelgrundner                                         $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-12-11 20:50:29 +0100 (Sa, 11 Dez 2010)                                           $
 * $LastChangedRevision:: 60                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/reflection/ReflectionClass.p#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection;

use HazAClass\System\Reflection\Usings\UsingsParser;
use HazAClass\System\Reflection\Attributes\AttributeBuilder;

class ReflectionClass extends \ReflectionClass
{

	public static $classname = __CLASS__;
	private $usings;
	private $attributes;

	public function HasAttribute($name)
	{
		return $this->GetAttributes()->IndexExists($name);
	}

	public function GetAttribute($name)
	{
		return $this->GetAttributes()->offsetGet($name);
	}

	/**
	 * @return GenericList
	 */
	public function GetAttributes()
	{
		if($this->attributes === null)
		{
			$builder = new AttributeBuilder($this);
			$this->attributes = $builder->getAttributes();
		}
		return $this->attributes;
	}

	public function getConstructor()
	{
		return $this->createOverrideReflectionMethod(parent::getConstructor());
	}

	/**
	 * @param string $name
	 * @return ReflectionMethod
	 */
	public function getMethod($name)
	{
		return $this->createOverrideReflectionMethod(parent::getMethod($name));
	}

	public function getMethods($filter = -1)
	{
		$result = array();
		foreach(parent::getMethods($filter) as $method)
			$result[] = $this->createOverrideReflectionMethod($method);

		return $result;
	}

	/**
	 * @param string $name
	 * @return ReflectionProperty
	 */
	public function getProperty($name)
	{
		return $this->createOverrideReflectionProperty(parent::getProperty($name));
	}

	public function getProperties($filter = -1)
	{
		$result = array();
		foreach(parent::getProperties($filter) as $property)
			$result[] = $this->createOverrideReflectionProperty($property);

		return $result;
	}

	public function getInterfaces()
	{
		$result = array();
		foreach(parent::getInterfaces() as $interface)
			$result[] = $this->createOverrideReflectionClass($interface);

		return $result;
	}

	public function getParentClass()
	{
		$class = parent::getParentClass();
		return $this->createOverrideReflectionClass($class);
	}

	private function createOverrideReflectionClass($class)
	{
		return ($class !== false) ? new ReflectionClass($class->getName()) : false;
	}

	private function createOverrideReflectionMethod($method)
	{
		return ($method !== null) ? new ReflectionMethod($this->getName(), $method->getName()) : null;
	}

	private function createOverrideReflectionProperty($property)
	{
		return ($property !== null) ? new ReflectionProperty($this->getName(), $property->getName()) : null;
	}

	/**
	 * @return ArrayList
	 */
	public function GetUsings()
	{
		if($this->usings === null)
		{
			$parser = new UsingsParser($this);
			$this->usings = $parser->GetUsings();
		}

		return $this->usings;
	}
}

?>
