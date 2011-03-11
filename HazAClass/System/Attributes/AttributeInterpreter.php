<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeInterpreter.php 44 2010-11-26 16:22:21Z manuelgrundner                                    $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-26 17:22:21 +0100 (Fr, 26 Nov 2010)                                           $
 * $LastChangedRevision:: 44                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeInterpre#$
 * ********************************************************************************************************* */

namespace HazAClass\core\attributes;

use HazAClass\utils\ReflectionUtil;
use HazAClass\core\interpreter\IInterpreter;
use HazAClass\core\tokenizer\Token;
use HazAClass\core\tokenizer\Tokens;
use HazAClass\core\attributes\AttributeTokenizer;
use HazAClass\core\collections\Collection;
use HazAClass\core\debug\Debug;
use HazAClass\utils\StringUtil;

class AttributeInterpreter implements IInterpreter
{

	public static $classname = __CLASS__;
	private $valueHolders;
	private $currentValueHolder;

	public function __construct()
	{
		$this->valueHolders = new Collection(AttributeInterpreterValueHolder::$classname);
	}

	public function interpret($tokens)
	{
		$this->valueHolders->flush();
		$this->doInterpret($tokens);

		return $this->valueHolders;
	}

	protected function doInterpret(Tokens $tokens)
	{
		if(!$tokens->isA(AttributeTokenizer::T_ATTRIBUTE))
			$tokens->skipUntil(AttributeTokenizer::T_ATTRIBUTE);

		$this->interpretAttributes($tokens);
	}

	protected function interpretAttributes(Tokens $tokens)
	{
		while($tokens->hasNext())
		{
			$valueHolder = $this->interpretAttribute($tokens);
			if($valueHolder instanceof AttributeInterpreterValueHolder)
				$this->valueHolders[] = $valueHolder;
			else
				$tokens->moveNext();
		}
	}

	protected function interpretAttribute(Tokens $tokens)
	{
		if($tokens->isA(AttributeTokenizer::T_ATTRIBUTE) && $tokens->isNextTokenA(T_STRING))
		{
			$this->currentValueHolder = new AttributeInterpreterValueHolder($this->interpretAttributeClassname($tokens));

			if($tokens->isNextTokenA(AttributeTokenizer::T_BRACE_OPEN))
			{
				$tokens->skipUntil(AttributeTokenizer::T_BRACE_OPEN);
				$this->interpretValues($tokens);
			}
			return $this->currentValueHolder;
		}
		return null;
	}

	protected function interpretAttributeClassname(Tokens $tokens)
	{
		$tokens->skipUntil(\T_STRING);
		if($tokens->isA(\T_STRING))
			return $tokens->getCurrentToken()->getValue();
	}

	protected function interpretValues(Tokens $tokens)
	{
		if($tokens->isA(AttributeTokenizer::T_BRACE_OPEN))
		{
			while($tokens->hasNext())
			{
				if($tokens->getCurrentToken()->isA(AttributeTokenizer::T_BRACE_CLOSE))
					break;
				if(!$tokens->hasNext())
					throw new AttributeException('Syntaxerror: No Closing brace found');

				
				switch($tokens->GetCurrentTokenType())
				{

					case \T_STRING:
						$found = false;
						
						$this->currentValueHolder->addParam($this->tryInterpretEnumValue($tokens, $found));
						$this->currentValueHolder->addParam($this->tryInterpretClassConstantValue($tokens, $found));
						$this->currentValueHolder->addParam($this->tryInterpretStaticPropertyValue($tokens, $found));
						break;
					case T_ENCAPSED_AND_WHITESPACE:
					case T_CONSTANT_ENCAPSED_STRING:
						$this->currentValueHolder->addParam($this->interpretStringValue($tokens));
						break;
					case T_DNUMBER:
						$this->currentValueHolder->addParam($this->interpretFloatValue($tokens));
						break;
					case T_LNUMBER:
						$this->currentValueHolder->addParam($this->interpretIntValue($tokens));
						break;
					case AttributeTokenizer::T_TRUE:
					case AttributeTokenizer::T_FALSE:

						$this->currentValueHolder->addParam($this->interpretBoolValue($tokens));
						break;
				}
				$tokens->moveNext();
			}
		}
	}

	protected function interpretBoolValue(Tokens $tokens)
	{
		$p = new AttributeInterpreterValueHolderParameterNative();
		$v = (boolean) $tokens->getCurrentToken()->getValue();
		$p->setValue($v);
		return $p;
	}

	protected function interpretIntValue(Tokens $tokens)
	{
		$p = new AttributeInterpreterValueHolderParameterNative();
		$v = (int) $tokens->getCurrentToken()->getValue();
		$p->setValue($v);
		return $p;
	}

	protected function interpretFloatValue(Tokens $tokens)
	{
		$p = new AttributeInterpreterValueHolderParameterNative();
		$v = (float) $tokens->getCurrentToken()->getValue();
		$p->setValue($v);
		return $p;
	}

	protected function interpretStringValue(Tokens $tokens)
	{
		$p = new AttributeInterpreterValueHolderParameterNative();
		$v = (string) $tokens->getCurrentToken()->getValue();
		$this->removeApostrophes($v);
		$p->setValue($v);
		return $p;
	}

	private function removeApostrophes(&$string)
	{
		$char = '\'';
		if(!$this->removeTrailingAndLeadingChar($string, $char))
			$this->removeDoubleQuote($string);
	}

	private function removeDoubleQuote(&$string)
	{
		$this->removeTrailingAndLeadingChar($string, '"');
	}

	private function removeTrailingAndLeadingChar(&$string, $char)
	{
		if(StringUtil::startsWith($string, $char))
		{
			$string = StringUtil::removeBegin($string, $char);
			$string = StringUtil::removeEnd($string, $char);
			return true;
		}
		return false;
	}

	protected function tryInterpretEnumValue(Tokens $tokens, &$found)
	{
		if($found)
			return;
		$tokens->resetPeak();
		if($tokens->peak()->isA(\T_DOUBLE_COLON))
		{
			if($tokens->peak()->isA(\T_STRING))
			{
				if($tokens->peak()->isA(AttributeTokenizer::T_BRACE_OPEN))
				{
					if($tokens->peak()->isA(AttributeTokenizer::T_BRACE_CLOSE))
					{
						$param = new AttributeInterpreterValueHolderParameterEnum();
						$param->setEnumType((string) $tokens->getCurrentToken()->getValue());
						$tokens->moveNext();
						$tokens->skipUntil(\T_STRING);
						$param->setValue((string) $tokens->getCurrentToken()->getValue());
						$tokens->skipUntil(AttributeTokenizer::T_BRACE_OPEN);
						$tokens->skipUntil(AttributeTokenizer::T_BRACE_CLOSE);
						
						$found = true;
						return $param;
					}
				}
			}
		}
	}

	protected function tryInterpretClassConstantValue(Tokens $tokens, &$found)
	{
		if($found)
			return;
		$tokens->resetPeak();
		if($tokens->peak()->isA(\T_DOUBLE_COLON))
			if($tokens->peak()->isA(\T_STRING))
			{
				$param = new AttributeInterpreterValueHolderParameterClassConstant();
				$param->setConstantName((string) $tokens->getCurrentToken()->getValue());
				$tokens->moveNext();
				$tokens->skipUntil(\T_STRING);
				$param->setValue((string) $tokens->getCurrentToken()->getValue());
				$found = true;

				return $param;
			}
	}

	protected function tryInterpretStaticPropertyValue(Tokens $tokens, &$found)
	{

		if($found)
			return;
		$tokens->resetPeak();
		if($tokens->peak()->isA(\T_DOUBLE_COLON))
			if($tokens->peak()->isA(\T_VARIABLE))
			{
				$param = new AttributeInterpreterValueHolderParameterStaticProperty();
				$param->setPropertyName((string) $tokens->getCurrentToken()->getValue());
				$tokens->moveNext();
				$tokens->skipUntil(T_VARIABLE);
				$param->setValue((string) $tokens->getCurrentToken()->getValue());
				$found = true;
				return $param;
			}
	}

}

?>
