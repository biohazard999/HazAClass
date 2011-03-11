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

namespace HazAClass\core\reflection;

use HazAClass\core\cache\CacheHelper;
use HazAClass\core\cache\CacheInvalidatedException;
use HazAClass\core\cache\iCacheProvider;
use HazAClass\core\debug\Debug;
use HazAClass\core\attributes\AttributeBuilder;
use HazAClass\utils\ClassNameUtil;
use HazAClass\HAF\attributes\GetterAttribute;
use HazAClass\HAF\attributes\SetterAttribute;

class ReflectionProperty extends \ReflectionProperty
{

	public static $classname = __CLASS__;
	private $attributes;

	public function hasAttribute($name)
	{
		return $this->getAttributes()->hasIndex($name);
	}

	public function getAttribute($name)
	{
		return $this->getAttributes()->get($name);
	}

	public function getSetterName()
	{
		if($this->hasAttribute(SetterAttribute::$classname))
			return $this->getAttribute(SetterAttribute::$classname)->getSetterName();
		return ClassNameUtil::buildSetterName($this->name);
	}

	public function getGetterName()
	{
		if($this->hasAttribute(GetterAttribute::$classname))
			return $this->getAttribute(GetterAttribute::$classname)->getGetterName();
		return ClassNameUtil::buildGetterName($this->name);
	}

	/**
	 * @return Map[Attribute]
	 */
	public function getAttributes()
	{
		if($this->attributes === null)
		{
			$fileCache = ReflectionClass::getFileChangedCache();
			$attributesCache = ReflectionClass::getAttributesCache();

			$name = $this->getCacheKeyName();

			try
			{
				CacheHelper::checkFileChange($fileCache, $this->getDeclaringClass()->getFileName());
				return $attributesCache->getValue($name);
			}
			catch(CacheInvalidatedException $e)
			{
				$builder = new AttributeBuilder($this);
				$attributesCache->store($name, $builder->getAttributes(), iCacheProvider::NEVER);
				$this->attributes = $builder->getAttributes();
			}
		}
		return $this->attributes;
	}

	protected function getCacheKeyName()
	{
		if($this->isStatic())
			return $this->getDeclaringClass()->getName().'::$'.$this->getName();

		return $this->getDeclaringClass()->getName().'->'.$this->getName();
	}

	public function getDeclaringClass()
	{
		$class = parent::getDeclaringClass();
		return new ReflectionClass($class->getName());
	}

	public function getUsings()
	{
		return $this->getDeclaringClass()->getUsings();
	}

	public function inNamespace()
	{
		return $this->getDeclaringClass()->inNamespace();
	}

	public function getNamespaceName()
	{
		return $this->getDeclaringClass()->getNamespaceName();
	}

	public function getFileName()
	{
		return $this->getDeclaringClass()->getFileName();
	}

}

?>
