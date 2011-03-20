<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeBuilder.php 103 2011-01-25 08:59:46Z manuelgrundner                                       $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2011-01-25 09:59:46 +0100 (Di, 25 Jän 2011)                                          $
 * $LastChangedRevision:: 103                                                                               $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeBuilder.#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection\Attributes;

use HazAClass\core\tokenizer\Tokens;
use HazAClass\core\tokenizer\Token;
use HazAClass\System\Collection\Generic\GenericList;
use HazAClass\System\Attribute;
use HazAClass\System\Type;
use HazAClass\System\TypeManager;
use HazAClass\System\Reflection\ReflectionClass;

class AttributeBuilder
{

	public static $classname = __CLASS__;
	private $reflector;
	private $reflectionClass;
	private $attributes;
	private $attributeValueHolders;

	const NS_SEP = '\\';

	public function __construct(\Reflector $ref)
	{
		if(!($ref instanceof \ReflectionFunctionAbstract) && !($ref instanceof \ReflectionClass) && !($ref instanceof \ReflectionProperty))
			throw new AttributeException('Can only handle instances of:
											[\ReflectionFunctionAbstract,
											 \ReflectionClass,
											 \ReflectionProperty]
									      Given:
										    '.get_class($ref));


		$this->reflector = $ref;
		if(!($ref instanceof \ReflectionClass))/* @var $ref ReflectionProperty */
			$this->reflectionClass = $ref->getDeclaringClass();
		else
			$this->reflectionClass = $ref;
		$this->attributeValueHolders = new GenericList(AttributeInterpreterValueHolder::$classname);
	}

	public function GetAttributes()
	{
		if($this->attributes === null)
		{
			$this->attributes = new GenericList(Attribute::$classname);
			$this->build();
		}
		return $this->attributes;
	}

	protected function build()
	{
		$docBlock = $this->reflector->getDocComment();
		if(empty($docBlock))
			return;


		$parser = new AttributesParser();
		$output = $parser->Parse($docBlock);


		$tokenizer = new AttributeTokenizer();
		$tokens = $tokenizer->Tokenize($output);

		$interpreter = new AttributeInterpreter();
		$this->attributeValueHolders = $interpreter->Interpret($tokens);
		$this->Create();
	}

	public function Create()
	{
		foreach($this->attributeValueHolders as $valueHolder)/* @var $valueHolder AttributeInterpreterValueHolder */
		{
			try
			{
				$classname = $this->getResolusedClassname($valueHolder);
				$valueHolder->setFullResolusedClassname($classname);
				$valueHolder->setReflectionClass($this->reflectionClass);
				$valueHolder->setReflection($this->reflector);
			}
			catch(AttributeException $e)
			{
				continue; //@todo überprüfen ob das sinnvoll ist
			}

			if(!is_subclass_of($classname, Attribute::$classname))
				throw new \InvalidArgumentException('An Attribute must be decendet by '.Attribute::$classname.'
											  Given: '.$classname);

			$attribute = $this->invoke($classname, $valueHolder->getUnnamedParamsAsArray());



			$this->setNamedParams($attribute, $valueHolder->getNamedParamsAsArray());




			$this->attributes[get_class($attribute)] = $attribute;
		}
	}

	private function Invoke($classname, array $params)
	{
		$refClass = typeof($classname)->GetReflectionClass();
		try
		{
			if($refClass->getConstructor() !== null && count($refClass->getConstructor()->getParameters()) > 0)
				return $refClass->newInstanceArgs($params);
			return $refClass->newInstanceArgs();
		}
		catch(\Exception $e)
		{
			throw new AttributeException('Could not instanciate '.$classname, 500, $e);
		}
	}

	protected function SetNamedParams(Attribute $attribute, array $params)
	{
		foreach($params as $name => $value)
		{
			$propRef = $attribute->GetType()->GetReflectionClass()->getProperty($name);
			if($propRef->isPublic())
			{
				$propRef->setValue($attribute, $value);
			}
			else
			{
			$setter = $attribute->GetType()->SetterOf($name);
			$attribute->$setter($value);
			}
		}
	}

	private function getResolusedClassname(AttributeInterpreterValueHolder $valueHolder)
	{
		if($valueHolder->isFullQualified())
		{
			$name = $valueHolder->getShortName();
			if(Type::IsTypeExisting($name) && $this->checkAttributeDecendence($name))
				return $name;

			$name = $valueHolder->getFullName();
			if(Type::IsTypeExisting($name) && $this->checkAttributeDecendence($name))
				return $name;
		}
		else
		{
			$name = self::NS_SEP.$valueHolder->getShortName();

			if(Type::IsTypeExisting($name) && $this->checkAttributeDecendence($name))
				return $name;

			$name = self::NS_SEP.$valueHolder->getFullName();
			if(Type::IsTypeExisting($name) && $this->checkAttributeDecendence($name))
				return $name;
		}

		$reflector = $this->reflector instanceof ReflectionClass ? $this->reflector : $this->reflector->getDeclaringClass();

		if($reflector->inNamespace())
		{
			$ns = $reflector->getNamespaceName().self::NS_SEP;
			$name = $ns.$valueHolder->getShortName();
			if(Type::IsTypeExisting($name) && $this->checkAttributeDecendence($name))
				return $name;

			$name = $ns.$valueHolder->getFullName();
			if(Type::IsTypeExisting($name) && $this->checkAttributeDecendence($name))
				return $name;
		}

		if($this->reflector instanceof ReflectionClass)
			$refUsings = $this->reflector->getUsings();
		else
			$refUsings = $this->reflector->getDeclaringClass()->getUsings();
		

		foreach($refUsings as $shortName => $fullName)
			if($shortName === $valueHolder->getFullName() || $shortName === $valueHolder->getShortName())
				if(Type::IsTypeExisting($fullName) && $this->checkAttributeDecendence($fullName))
					return $fullName;





		throw new AttributeException('Could not resolute Attributes classname:
									  Attribute searched: '.$valueHolder->getFullName().'
									  in File: '.$this->reflector->getFileName());
	}

	private function checkAttributeDecendence($classname)
	{
		return typeof($classname)->IsSubClass(Attribute::$classname);
	}

}

?>
