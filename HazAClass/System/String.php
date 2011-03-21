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
	const SPACE_STRING = ' ';
	const NEW_LINE = "\n";

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

	/**
	 * @return string
	 */
	public function ToString()
	{
		return $this->string;
	}

	/**
	 * @param string $str1, string $str2, string $str3, ...
	 * @return String 
	 */
	public function Concat()
	{
		$arr = func_get_args();
		foreach($arr as $value)
			$this->string .= $value;
		return $this;
	}

	/**
	 * @param int $start
	 * @param int $len
	 * @return String 
	 */
	public function SubString($start = 0, $len = null)
	{
		if($len === null)
			$this->string = substr($this->string, $start);
		else
			$this->string = substr($this->string, $start, $len);
		return $this;
	}

	/**
	 * @return int
	 */
	public function Length()
	{
		return strlen($this->string);
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return $this->Length();
	}

	/**
	 * @param string $search
	 * @return bool
	 */
	public function InString($search)
	{
		if($search === '')
			throw new InvalidArgumentException('Search string must not be an empty string');

		return $this->Position($search) !== null;
	}

	/**
	 * @param string $search
	 * @return bool
	 */
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

	/**
	 * @param string $search
	 * @return bool
	 */
	public function StartsWith($search)
	{
		$clone = clone $this;

		return $clone->SubString(0, self::Instance($search)->Length()) == $search;
	}

	/**
	 * @param string $search
	 * @return bool
	 */
	public function EndsWith($search)
	{
		$str = clone ($this);

		return $str->SubString(String::Instance($search)->Length($search) * -1)->ToString() == $search;
	}

	/**
	 * @param string $remove
	 * @param int $count
	 * @return String
	 */
	public function Remove($remove, $count = null)
	{
		if($this->string === $remove)
			return '';
		return $this->Replace($remove, '', $count);
	}

	/**
	 * @param string $remove
	 * @return String 
	 */
	public function RemoveEnd($remove)
	{
		if($this->EndsWith($remove))
			return $this->SubString(0, String::Instance($remove)->Length() * -1);

		return $this;
	}

	/**
	 * @param string $remove
	 * @return String 
	 */
	public function RemoveBegin($remove)
	{
		if($this->StartsWith($remove))
			return $this->SubString(String::Instance($remove)->Length());

		return $this;
	}

	/**
	 * @param string $search
	 * @param string $replace
	 * @param int $count
	 * @return String 
	 */
	public function Replace($search, $replace, $count = null)
	{
		$this->string = str_replace($search, $replace, $this->string, $count);
		return $this;
	}

	/**
	 * @param string $search
	 * @return bool
	 */
	public function Position($search)
	{
		$result = strpos($this->string, $search);
		return $result === false ? null : $result;
	}

	/**
	 * @param string $search
	 * @return bool
	 */
	public function ReversePosition($search)
	{
		$result = strrpos($this->string, $search);
		return $result === false ? null : $result;
	}

	/**
	 * @param int $multiplier
	 * @return String 
	 */
	public function Repeat($multiplier)
	{
		$multiplier = $multiplier > 0 ? $multiplier : 0;
		$this->string = str_repeat($this->string, $multiplier);
		return $this;
	}

	/**
	 * @param string $prefix
	 * @param string $postfix
	 * @return String 
	 */
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

	/**
	 * @return String 
	 */
	public function Trim()
	{
		$this->string = trim($this->string);
		return $this;
	}

	/**
	 * @return String 
	 */
	public function TrimLeft()
	{
		$this->string = ltrim($this->string);
		return $this;
	}

	/**
	 * @return String 
	 */
	public function TrimRight()
	{
		$this->string = rtrim($this->string);
		return $this;
	}

	/**
	 * @return String 
	 */
	public function LowerCase()
	{
		$this->string = strtolower($this->string);
		return $this;
	}

	/**
	 * @return String 
	 */
	public function UpperCase()
	{
		$this->string = strtoupper($this->string);
		return $this;
	}

	/**
	 * @return String 
	 */
	public function UpperCaseFirst()
	{
		$this->string = ucfirst($this->string);
		return $this;
	}

	/**
	 * @return String 
	 */
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
