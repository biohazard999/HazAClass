<?php
/** * *******************************************************************************************************$
 * $Id:: ReflectionProperty.php 95 2011-01-10 17:00:39Z manuelgrundner                                      $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2011-01-10 18:00:39 +0100 (Mo, 10 Jän 2011)                                          $
 * $LastChangedRevision:: 95                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/reflection/ReflectionPropert#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection;

use HazAClass\System\Reflection\Attributes\AttributeBuilder;

class ReflectionProperty extends \ReflectionProperty
{

	public static $classname = __CLASS__;
	private $attributes;

	public function HasAttribute($name)
	{
		if($name instanceof Type)
			$name = $name->GetFullName();
		return $this->getAttributes()->IndexExists($name);
	}

	public function GetAttribute($name)
	{
		if($name instanceof Type)
			$name = $name->GetFullName();
		return $this->getAttributes()->offsetGet($name);
	}

	public function GetSetterName()
	{
		if($this->HasAttribute(SetterAttribute::$classname))
			return $this->GetAttribute(SetterAttribute::$classname)->getSetterName();
		return ClassNameUtil::buildSetterName($this->name);
	}

	public function GetGetterName()
	{
		if($this->hasAttribute(GetterAttribute::$classname))
			return $this->getAttribute(GetterAttribute::$classname)->getGetterName();
		return ClassNameUtil::buildGetterName($this->name);
	}

	/**
	 * @return Map[Attribute]
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

	public function getDeclaringClass()
	{
		$class = parent::getDeclaringClass();
		return new ReflectionClass($class->getName());
	}
}

?>
