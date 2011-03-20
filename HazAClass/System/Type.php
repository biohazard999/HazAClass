<?php
/** * *******************************************************************************************************$
 * $Id:: DocumentHeadRenderer.php 199 2009-09-30 19:57:12Z manuelgrundner                                   $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2009-09-30 21:57:12 +0200 (Mi, 30 Sep 2009)                                           $
 * $LastChangedRevision:: 199                                                                               $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://jackonrock.dyndns.org:81/svn/HazAClassLite/branches/HazAClass53/framework/controls/doc#$
 * ********************************************************************************************************* */

namespace HazAClass\System;

use HazAClass\System\Reflection\ReflectionClass;

final class Type extends Object
{

	public static $classname = __CLASS__;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var ReflectionClass
	 */
	private $reflectionClass;

	public function __construct($objectType)
	{
		if(!Type::IsTypeExisting($objectType))
			throw new \InvalidArgumentException($objectType.' is not existing');
		$this->type = $objectType;
	}

	public static function IsTypeExisting($objectType)
	{
		return class_exists($objectType) || interface_exists($objectType);
	}

	/**
	 * @return string The Classname of the corresponding object
	 */
	public function GetFullName()
	{
		return $this->type;
	}

	/**
	 * @param string $interfaceName
	 * @return bool
	 */
	public function ImplementsInterface($interfaceName)
	{
		if($interfaceName instanceof Type)
			$interfaceName = $interfaceName->GetFullName();
		return $this->GetReflectionClass()->implementsInterface($interfaceName);
	}

	/**
	 * @param Type $type
	 * @return bool
	 */
	public function IsTypeOf(Type $type)
	{
		if($type === $this)
			return true;
		return $this->IsSubClass($type->GetFullName());
	}

	/**
	 * @param string $classname
	 * @return bool
	 */
	public function IsSubClass($classname)
	{
		return $this->GetReflectionClass()->isSubclassOf($classname);
	}

	public function IsInterface()
	{
		return $this->GetReflectionClass()->isInterface();
	}

	public function IsClass()
	{
		return!$this->IsInterface();
	}

	public function IsInstantiable()
	{
		return $this->GetReflectionClass()->isInstantiable();
	}

	/**
	 * @return ReflectionClass
	 */
	public function GetReflectionClass()
	{
		if($this->reflectionClass === null)
			$this->reflectionClass = new ReflectionClass($this->GetFullName());
		return $this->reflectionClass;
	}

	/**
	 * @param IObject $obj
	 * @return ReflectionObject 
	 */
	public function GetReflectionObject(IObject $obj)
	{
		return new \ReflectionObject($obj);
	}

	/**
	 * Returns a setter-method-name from a propertyname
	 * @param string $propertyName
	 * @return string
	 */
	public function SetterOf($propertyName)
	{
		return self::buildCamelCaseMethod('set', $propertyName);
	}

	/**
	 * Returns a getter-method-name from a propertyname
	 *
	 * @param string $propertyName
	 * @return string
	 */
	public function GetterOf($propertyName)
	{
		return self::buildCamelCaseMethod('get', $propertyName);
	}

	private static function buildCamelCaseMethod($firstPart, $secondPart)
	{
		return String::CamelCase($firstPart, $secondPart)->ToString();
	}

	public function StaticMethod($methodname)
	{
		return $this->GetFullName().'::'.$methodname;
	}

	public function Method($methodname)
	{
		return $this->GetFullName().'->'.$methodname;
	}

	public function Constant($constantname)
	{
		return $this->GetFullName().'::'.$constantname;
	}

	public function IsInNamespace()
	{
		return $this->GetReflectionClass()->inNamespace();
	}

	public function GetNamespaceName()
	{
		return '\\'.$this->GetReflectionClass()->getNamespaceName();
	}

	public function GetShortName()
	{
		return $this->GetReflectionClass()->getShortName();
	}

	public function GetDirectory()
	{
		return dirname($this->getFileName());
	}

	public function GetFileName()
	{
		return $this->GetReflectionClass()->getFileName();
	}

	public static function IsClassnameParitallyQualified($classname)
	{
		return String::Instance($classname)->Contains('\\');
	}

	public static function IsClassnameFullQualified($classname)
	{
		return String::Instance($classname)->StartsWith('\\');
	}

	public function ToString()
	{
		return $this->GetFullName();
	}

}

?>
