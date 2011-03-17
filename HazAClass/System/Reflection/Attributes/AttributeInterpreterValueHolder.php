<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeInterpreterValueHolder.php 15 2010-11-08 00:48:00Z manuelgrundner                         $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-08 01:48:00 +0100 (Mo, 08 Nov 2010)                                           $
 * $LastChangedRevision:: 15                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeInterpre#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection\Attributes;

use HazAClass\System\Collection\Generic\GenericList;
use HazAClass\System\Attribute;
use HazAClass\System\String;
use HazAClass\System\Type;
use HazAClass\System\Reflection\ReflectionClass;
use HazAClass\System\TypeManager;

class AttributeInterpreterValueHolder
{

	public static $classname = __CLASS__;
	private $braceNesting = 0;
	private $name;
	private $params;
	private $currentParam;
	private $fullResolusedClassname;

	const NS_SEP = '\\';

	/**
	 * @var ReflectionClass
	 */
	private $reflectionClass;
	private $reflection;

	public function __construct($name)
	{
		$this->SetName($name);
		$this->params = new GenericList(AbstractAttributeInterpreterValueHolderParameter::$classname);
	}

	public function GetReflectionClass()
	{
		return $this->reflectionClass;
	}

	public function SetReflectionClass(\ReflectionClass $reflectionClass)
	{
		$this->reflectionClass = $reflectionClass;
	}

	public function getReflection()
	{
		return $this->reflection;
	}

	public function setReflection(\Reflector $reflection)
	{
		$this->reflection = $reflection;
	}

	public function getFullResolusedClassname()
	{
		return $this->fullResolusedClassname;
	}

	public function setFullResolusedClassname($fullResolusedClassname)
	{
		$this->fullResolusedClassname = $fullResolusedClassname;
	}

	public function hasFullResolusedClassname()
	{
		return $this->fullResolusedClassname !== null;
	}

	private function setName($name)
	{
		$this->name = $name;
	}

	public function getFullName()
	{
		if(!String::Instance($this->name)->EndsWith(Attribute::ATTRIBUTE_APPENDIX))
			return $this->name.Attribute::ATTRIBUTE_APPENDIX;
		return $this->name;
	}

	public function isFullQualified()
	{
		return Type::IsClassnameFullQualified($this->name);

	}

	public function isParitallyQualified()
	{
		return Type::IsClassnameParitallyQualified($this->name);
	}

	public function getFullQualifiedName()
	{
		return $this->name.Attribute::ATTRIBUTE_APPENDIX;
	}

	public function getShortName()
	{
		return String::Instance($this->name)->RemoveEnd(Attribute::ATTRIBUTE_APPENDIX);
	}

	public function addParam(AbstractAttributeInterpreterValueHolderParameter $param = null)
	{
		if($param !== null)
			$this->params[] = $param;
	}

	public function getCurrentParam()
	{
		return $this->currentParam;
	}

	public function getBraceNesting()
	{
		return $this->braceNesting;
	}

	public function setBraceNesting($braceNesting)
	{
		$this->braceNesting = $braceNesting;
	}

	public function getNamedParamsAsArray()
	{
		$array = array();
		foreach($this->params as $param)
			if($param->isNamed())
			{
				if($param instanceof AbstractAttributeInterpreterValueHolderParameterComplex)
					$array[$param->getName()] = $this->getComplexParameter($param);
				else
					$array[$param->getName()] = $param->getValue();
			}

		return $array;
	}

	public function getUnnamedParamsAsArray()
	{
		$array = array();
		foreach($this->params as $param)
			if(!$param->isNamed())
			{
				if($param instanceof AbstractAttributeInterpreterValueHolderParameterComplex)
					$array[] = $this->getComplexParameter($param);
				else
					$array[] = $param->getValue();
			}

		return $array;
	}

	private function getComplexParameter(AbstractAttributeInterpreterValueHolderParameterComplex $param)
	{
		if($param instanceof AttributeInterpreterValueHolderParameterEnum)
			return $this->getEnumParameterValue($param);
		if($param instanceof AttributeInterpreterValueHolderParameterClassConstant)
			return $this->getClassConstantParameterValue($param);
		if($param instanceof AttributeInterpreterValueHolderParameterStaticProperty)
			return $this->getStaticPropertyParameterValue($param);
	}

	public function getEnumParameterValue(AttributeInterpreterValueHolderParameterEnum $param)
	{
		if($this->hasFullResolusedClassname())
		{
			$enumName = $this->findComplexParamsFullName($param, $this->getReflectionClass());
			$param->setFullQualifiedName($enumName);
			$enumRef = TypeManager::GetTypeInstance($enumName)->GetReflectionClass();
			return \call_user_func(array($enumName, $param->getValue()));
		}
	}

	public function getClassConstantParameterValue(AttributeInterpreterValueHolderParameterClassConstant $param)
	{
		if($this->hasFullResolusedClassname())
		{
			$constantClassName = $this->findComplexParamsFullName($param, $this->getReflectionClass());
			$param->setFullQualifiedName($constantClassName);

			$constantRef = TypeManager::GetTypeInstance($constantClassName)->GetReflectionClass();
			return $constantRef->getConstant($param->getValue());
		}
	}

	public function getStaticPropertyParameterValue(AttributeInterpreterValueHolderParameterStaticProperty $param)
	{
		if($this->hasFullResolusedClassname())
		{
			$staticPropertyClassName = $this->findComplexParamsFullName($param, $this->getReflectionClass());
			$param->setFullQualifiedName($staticPropertyClassName);
			$constantRef = TypeManager::GetTypeInstance($staticPropertyClassName)->GetReflectionClass();
			return $constantRef->getProperty($param->getValue())->GetValue();
		}
	}

	private function findComplexParamsFullName(AbstractAttributeInterpreterValueHolderParameterComplex $param, ReflectionClass $ref)
	{
		if(Type::IsClassnameFullQualified($param->getShortName()))
		{
			if(Type::IsTypeExisting($param->getShortName()))
				return $param->getShortName();
		}
		else
		{
			$name = self::NS_SEP.$param->getShortName();
			if(Type::IsTypeExisting($name))
				return $name;
		}

		if($ref->inNamespace())
		{
			$ns = $ref->getNamespaceName().self::NS_SEP;
			$name = $ns.$param->getShortName();
			if(Type::IsTypeExisting($name))
				return $name;
		}

		$refUsings = $ref->getUsings();

		foreach($refUsings as $shortName => $fullName)
			if($shortName === $param->getShortName())
				if(Type::IsTypeExisting($fullName))
					return $fullName;
	}

}

?>
