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

class String extends Object implements \Countable
{

	public static $classname = __CLASS__;

	const EMPTY_STRING = '';

	private $string;

	public function __construct($str = '')
	{
		if(!is_string($str))
			throw new InvalidArgumentException('First param is not a string');

		$this->string = $str;
	}

	/**
	 *
	 * @param string $str
	 * @return String
	 */
	public static function Instance($str = '')
	{
		return new self($str);
	}

	public function ToString()
	{
		return $this->string;
	}

	public function Concat()
	{
		$arr = func_get_args();
		foreach($arr as $value)
			$this->string .= $value;
		return $this;
	}

	public function SubString($start = 0, $len = null)
	{
		if($len === null)
			$this->string = substr($this->string, $start);
		else
			$this->string = substr($this->string, $start, $len);
		return $this;
	}

	public function Length()
	{
		return strlen($this->string);
	}

	public function count()
	{
		return $this->Length();
	}

	public function InString($search)
	{
		if($search === '')
			throw new InvalidArgumentException('Search string must not be an empty string');

		return $this->Position($search) !== null;
	}

	public function Contains($search)
	{
		if(is_array($search))
		{
			$bool = false;
			foreach($search as $char)
			{
				$bool |= $this->InString($char);
			}
			return (bool) $bool;
		}
		return $this->InString($search);
	}

	public function StartsWith($search)
	{
		$clone = clone $this;

		return $clone->SubString(0, self::Instance($search)->Length()) == $search;
	}

	public function EndsWith($search)
	{
		$str = clone ($this);

		return $str->SubString(String::Instance($search)->Length($search) * -1)->ToString() == $search;
	}

	public function Remove($remove, $count = null)
	{
		if($this->string === $remove)
			return '';
		return $this->Replace($remove, '', $count);
	}

	public function RemoveEnd($remove)
	{
		if($this->EndsWith($remove))
			return $this->SubString(0, String::Instance($remove)->Length() * -1);

		return $this;
	}

	public function RemoveBegin($remove)
	{
		if($this->StartsWith($remove))
			return $this->SubString(String::Instance($remove)->Length());

		return $this;
	}

	public function Replace($search, $replace, $count = null)
	{
		$this->string = str_replace($search, $replace, $this->string, $count);
		return $this;
	}

	public function Position($search)
	{
		$result = strpos($this->string, $search);
		return $result === false ? null : $result;
	}

	public function ReversePosition($search)
	{
		$result = strrpos($this->string, $search);
		return $result === false ? null : $result;
	}

	public function Repeat($multiplier)
	{
		$multiplier = $multiplier > 0 ? $multiplier : 0;
		return str_repeat($this->string, $multiplier);
	}

	public function UUID($prefix = '', $postfix = '')
	{
		$chars = md5(uniqid(mt_rand(), true));
		$uuid = substr($chars, 0, 8).'-';
		$uuid .= substr($chars, 8, 4).'-';
		$uuid .= substr($chars, 12, 4).'-';
		$uuid .= substr($chars, 16, 4).'-';
		$uuid .= substr($chars, 20, 12);

		$this->string = $prefix.$uuid.$postfix;
		return $this;
	}

	public function Trim()
	{
		$this->string = trim($this->string);
		return $this;
	}

	public function TrimLeft()
	{
		$this->string = ltrim($this->string);
		return $this;
	}

	public function TrimRight()
	{
		$this->string = rtrim($this->string);
		return $this;
	}

	public function LowerCase()
	{
		$this->string = strtolower($this->string);
		return $this;
	}

	public function UpperCase()
	{
		$this->string = strtoupper($this->string);
		return $this;
	}

	public function UpperCaseFirst()
	{
		$this->string = ucfirst($this->string);
		return $this;
	}

	public function LowerCaseFirst()
	{
		$this->string = lcfirst($this->string);
		return $this;
	}

	/**
	 * @params string $param1, string $param2, string $param3, string ...
	 * @return String 
	 */
	public static function CamelCase()
	{
		$args = func_get_args();
		$str = new String();
		foreach($args as $arg)
			$str->Concat(String::Instance($arg)->UpperCaseFirst());

		return $str;
	}

}

?>
