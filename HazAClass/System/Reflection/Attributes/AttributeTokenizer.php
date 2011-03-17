<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeTokenizer.php 4 2010-11-06 12:37:02Z manuelgrundner                                       $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeTokenize#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection\Attributes;

use HazAClass\System\Parser\Token\AbstractTokenizer;

class AttributeTokenizer extends AbstractTokenizer
{

	public static $classname = __CLASS__;

	const T_ATTRIBUTE = '@';
	const T_DOLLAR = '$';
	const T_NAMESPACE_SEPERATOR = '\\';
	const T_STAR_COMMENT_BEGIN = '/*';
	const T_STAR = '*';
	const T_STAR_COMMENT_END = '*/';
	const T_PHP_OPEN_TAG = '<?php';
	const T_PHP_CLOSE_TAG = '?>';
	const T_BRACE_OPEN = '(';
	const T_BRACE_CLOSE = ')';
	const T_OPERATOR_ASSIGN = '=';
	const T_OPERATOR_COMMA = ',';
	const T_TRUE = 'true';
	const T_FALSE = 'false';

	public function Tokenize($input)
	{
		$input = self::T_PHP_OPEN_TAG.' '.$input.' '.self::T_PHP_CLOSE_TAG;
		return parent::Tokenize($input);
	}

	protected function IsUnderstandableToken($token)
	{
		switch($token)
		{
			case self::T_ATTRIBUTE:
			case self::T_BRACE_OPEN:
			case self::T_BRACE_CLOSE:
			case self::T_OPERATOR_ASSIGN:
			case self::T_OPERATOR_COMMA:
			case self::T_OPERATOR_ASSIGN:
			case self::T_TRUE:
			case self::T_FALSE:
			case self::T_DOLLAR:
			case \T_STRING:
			case \T_CONSTANT_ENCAPSED_STRING:
			case \T_PAAMAYIM_NEKUDOTAYIM:
			case \T_DOUBLE_COLON:
			case \T_LNUMBER:
			case \T_DNUMBER:
			case \T_VAR:
			case \T_VARIABLE:
				return true;
		}
		return false;
	}

	protected function ModifyIDBeforeCreating($id, $value)
	{
		if($id == \T_STRING)
		{
			if($value == self::T_TRUE)
				return self::T_TRUE;
			elseif($value == self::T_FALSE)
				return self::T_FALSE;
		}
	}

	protected function ModifyValueBeforeCreating($id, $value)
	{
		if($id == self::T_TRUE)
			return true;
		elseif($id == self::T_FALSE)
			return false;
	}

}

?>
