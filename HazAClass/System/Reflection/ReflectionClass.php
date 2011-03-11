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

namespace HazAClass\Reflection;

use HazAClass\utils\StringCaseUtil;
use HazAClass\utils\ReflectionUtil as Util;
use HazAClass\core\config\system\performance\UsingsCache;
use HazAClass\core\cache\CacheInvalidatedException;
use HazAClass\core\cache\iCacheProvider;
use HazAClass\core\config\system\performance\Attributes;
use HazAClass\core\config\system\performance\FileChangedCache;
use HazAClass\core\cache\CacheFactory;
use HazAClass\core\cache\CacheHelper;
use HazAClass\core\debug\Debug;
use HazAClass\core\attributes\AttributeBuilder;
use HazAClass\utils\ClassNameUtil;
use HazAClass\System\Collection\ArrayList;

class ReflectionClass extends \ReflectionClass
{

	public static $classname = __CLASS__;
	private $usings;
	private $attributes;

	public function HasAttribute($name)
	{
		return $this->getAttributes()->hasIndex($name);
	}

	public function GetAttribute($name)
	{
		return $this->getAttributes()->get($name);
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
			$this->usings = $this->parseUsings();

		return $this->usings;
	}

	protected function parseUsings()
	{
		$usingTokenParts = token_get_all(file_get_contents($this->getFileName()));

		$usingTokenParts = $this->filterTokens($usingTokenParts);

		$usings = new ArrayList();
		foreach($usingTokenParts as $token)
		{
			if($this->hasAlias($token))
				$alias = $this->getAlias($token);
			else
				$alias = $this->getResolvedClassname($token);
			$usings[$alias] = $this->getFullQualifiedClassname($token);
		}

		return $usings;
	}

	private function filterTokens($tokens)
	{
		$collect = false;
		$collected = array();
		$i = -1;
		foreach($tokens as $token)
		{
			if(is_int($token[0]))
			{
				if($token[0] == \T_USE)
				{
					$i++;
					$collect = true;
					continue;
				}

				if($collect)
					switch($token[0])
					{
						case \T_STRING:
						case \T_NS_SEPARATOR:
						case \T_AS: {
								$token[3] = token_name($token[0]);
								$collected[$i][] = $token;
								break;
							}
					}
			}
			elseif($token === ';')
				$collect = false;
			elseif($token === ',' && $collect)
				$i++;
		}
		return $collected;
	}

	private function hasAlias($tokens)
	{
		foreach($tokens as $token)
			if($token[0] === \T_AS)
				return true;
		return false;
	}

	private function getAlias($tokens)
	{
		return $tokens[count($tokens) - 1][1];
	}

	private function getResolvedClassname($tokens)
	{
		return $tokens[count($tokens) - 1][1];
	}

	private function getFullQualifiedClassname($tokens)
	{
		$classname = '\\';
		foreach($tokens as $token)
		{
			switch($token[0])
			{
				case \T_NS_SEPARATOR:
				case \T_STRING:
					$classname .= $token[1];
					break;
				case \T_AS:
					return $classname;
			}
		}
		return $classname;
	}

}

?>
