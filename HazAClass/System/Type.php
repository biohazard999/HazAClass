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

class Type extends Object
{

	public static $classname = __CLASS__;
	/**
	 * @var IObject
	 */
	private $instance;

	public function __construct(IObject $object)
	{
		$this->instance = $object;
	}

	/**
	 * @return string The Classname of the corresponding object
	 */
	public function GetFullName()
	{
		return $this->instance->GetClassName();
	}

	/**
	 * @param string $interfaceName
	 * @return bool
	 */
	public function ImplementsInterface($interfaceName)
	{
		return $this->instance instanceof $interface;
	}

	/**
	 * @param Type $type
	 * @return bool
	 */
	public function IsTypeOf(Type $type)
	{
		$name = $type->GetFullName();
		return $this->instance instanceof $name;
	}

	/**
	 * @param string $classname
	 * @return bool
	 */
	public function IsClass($classname)
	{
		return $this->instance instanceof $classname;
	}

	/**
	 * @return ReflectionClass
	 */
	public function GetReflectionClass()
	{
		return new ReflectionClass($this->GetFullName());
	}

	/**
	 * @return ReflectionObject
	 */
	public function GetReflectionObject()
	{
		return new ReflectionObject($this->instance);
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
		return String::CamelCase($firstPartm, $secondPart)->ToString();
	}

	public function StaticMethod($methodname)
	{
		return $this->GetFullName().'::'.$methodname;
	}

	public function Method($methodname)
	{
		return $this->GetFullName().'->'.$methodname;
	}

	public function Constant($classname, $constantname)
	{
		return $this->GetFullName().'::'.$constantname;
	}

	public function IsInNamespace($classname)
	{
		return $this->GetReflectionClass()->inNamespace();
	}

	public function GetNamespaceName()
	{
		return $this->GetReflectionClass()->getNamespaceName();
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
}

?>
