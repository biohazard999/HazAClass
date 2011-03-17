<?php

/** * *******************************************************************************************************$
 * $Id:: ReflectionMethod.php 4 2010-11-06 12:37:02Z manuelgrundner                                         $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-06 13:37:02 +0100 (Sa, 06 Nov 2010)                                           $
 * $LastChangedRevision:: 4                                                                                 $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/reflection/ReflectionMethod.#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection;

use HazAClass\core\cache\CacheHelper;
use HazAClass\core\cache\CacheInvalidatedException;
use HazAClass\core\cache\iCacheProvider;
use HazAClass\core\debug\Debug;
use HazAClass\core\attributes\AttributeBuilder;

class ReflectionMethod extends \ReflectionMethod
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
				CacheHelper::checkFileChange($fileCache, $this->getFileName());

				$v = $attributesCache->GetValue($name);
				return $v;
			}
			catch(CacheInvalidatedException $e)
			{
				Debug::log($e->getMessage());

				$builder = new AttributeBuilder($this);

				$attributesCache->store($name, $builder->getAttributes(), iCacheProvider::NEVER);
				$this->attributes = $builder->getAttributes();
			}
		}
		return $this->attributes;
	}

	private function getCacheKeyName()
	{
		if($this->isStatic())
			return $this->getDeclaringClass()->getName().'::'.$this->getName().'()';

		return $this->getDeclaringClass()->getName().'->'.$this->getName().'()';
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
