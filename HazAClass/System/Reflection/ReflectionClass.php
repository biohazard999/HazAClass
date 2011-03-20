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
use HazAClass\System\Collection\Generic\GenericList;
use HazAClass\System\Type;

class ReflectionClass extends \ReflectionClass
{

	public static $classname = __CLASS__;
	private $usings;
	private $attributes;
	/**
	 * @var GenericList
	 */
	private $methods;
	/**
	 * @var GenericList
	 */
	private $properties;
	/**
	 * @var GenericList
	 */
	private $interfaces;

	public function HasAttribute($name)
	{
		if($name instanceof Type)
			$name = $name->GetFullName();
		return $this->GetAttributes()->IndexExists($name);
	}

	public function GetAttribute($name)
	{
		if($name instanceof Type)
			$name = $name->GetFullName();
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

	/**
	 * @return ReflectionMethod
	 */
	public function getConstructor()
	{
		$ctor = parent::getConstructor();
		if($ctor === null)
			return;
		return $this->_getMethod($ctor->getName());
	}

	/**
	 * @param string $name
	 * @return ReflectionMethod
	 */
	public function getMethod($name)
	{
		return $this->_getMethod($name);
	}

	private function _getMethod($name)
	{
		if($this->methods === null)
			$this->methods = new GenericList(ReflectionMethod::$classname);

		if($this->methods->IndexExists($name))
			return $this->methods[$name];

		return $this->methods[$name] = $this->createOverrideReflectionMethod(parent::getMethod($name));
	}

	/**
	 * @param int $filter
	 * @return IList
	 */
	public function getMethods($filter = -1)
	{
		$result = new GenericList(ReflectionMethod::$classname);
		foreach(parent::getMethods($filter) as $method)
			$result[$method->getName()] = $this->_getMethod($method->getName());

		return $result;
	}

	/**
	 * @param string $name
	 * @return ReflectionProperty
	 */
	public function getProperty($name)
	{
		return $this->_getProperty($name);
	}

	private function _getProperty($name)
	{
		if($this->properties === null)
			$this->properties = new GenericList(ReflectionProperty::$classname);

		if($this->properties->IndexExists($name))
			return $this->properties[$name];

		return $this->properties[$name] = $this->createOverrideReflectionProperty(parent::getProperty($name));
	}

	/**
	 * @param int $filter
	 * @return IList
	 */
	public function getProperties($filter = -1)
	{
		$result = new GenericList(ReflectionProperty::$classname);
		foreach(parent::getProperties($filter) as $property)
			$result[$property->getName()] = $this->_getProperty($property->getName());

		return $result;
	}

	public function getInterfaces()
	{
		if($this->interfaces === null)
		{
			$this->interfaces = new GenericList(ReflectionClass::$classname);
			foreach(parent::getInterfaces() as $interface)
				$this->interfaces[$interface->getName()] = $this->createOverrideReflectionClass($interface);
		}

		return $this->interfaces;
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
