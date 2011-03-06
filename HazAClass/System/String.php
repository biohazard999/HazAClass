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

class String extends Object
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

	public function Concat($str = '')
	{
		$this->string .= $str;
		return $this;
	}
	
	/**
	 * Substrings a string
	 *
	 * @see http://www.php.net/manual/en/function.substr.php
	 * @param $str
	 * @param $start
	 * @param $len
	 * @return String
	 */
	public function SubString($start = 0, $len = null)
	{
		if($len === null)
			$this->string = substr($this->str, $start);
		else
			$this->string = substr($this->string, $start, $len);
		return $this;
	}

	/**
	 * Returns the lenght of a string
	 *
	 * @see http://www.php.net/manual/en/function.strlen.php
	 * @param string $str
	 * @return int
	 */
	public function Length()
	{
		return strlen($this->string);
	}

	/**
	 * Returns true if a string/char is in a given string
	 *
	 * @param string $string
	 * @param string $search
	 * @throws InvalidArgumentException
	 * @return boolean
	 */
	public function InString($search)
	{
		if($search === '')
			throw new InvalidArgumentException('Search string must not be an empty string');
		return $this->Position($search) !== null;
	}

	/**
	 * @param string $string
	 * @param string|array $search
	 * @return bool
	 */
	public function Contains($search)
	{
		if(is_array($search))
		{
			$bool = false;
			foreach($search as $char)
				$bool &= $this->InString($char);
			return $bool;
		}
		return $this->InString($search);
	}

	/**
	 * Returns true if a string starts with a given string
	 *
	 * @param string $string
	 * @param string $search
	 * @return boolean
	 */
	public function StartsWith($search)
	{
		return $this->SubString(0, self::Instance($search)->Length()) == $search;
	}

	/**
	 * Returns true if a string starts with a given string
	 *
	 * @param string $string
	 * @param string $search
	 * @return boolean
	 */
	public function EndsWith($search)
	{
		$str = clone ($this);
		
		return $str->SubString(String::Instance($search)->Length($search) * -1)->ToString() == $search;
	}

	/**
	 * Removes stringparts from a string
	 *
	 * @param string $string
	 * @param string $remove
	 * @return string
	 */
	public function Remove($string, $remove, $count = null)
	{
		if($string === $remove)
			return '';
		return self::replace($string, $remove, '', $count);
	}

	/**
	 * Removes the end of a string if it equals the remove string given
	 *
	 * @param string $string
	 * @param string $remove
	 * @return string
	 */
	public function RemoveEnd($remove)
	{
		if($this->EndsWith($remove))
			return $this->SubString(0, String::Instance($remove) * -1);

		return $this;
	}

	public function RemoveBegin($remove)
	{
		if($this->StartsWith($remove))
			return $this->SubString(String::Instance($remove)->Length());

		return $this;
	}

	/**
	 * Replaces a string
	 *
	 * @param string $string
	 * @param string $search
	 * @param string $replace
	 * @return string
	 */
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

	/**
	 * Returns the index of a character or string from the reverse position
	 * If nothing is found null is returned
	 *
	 * @param string $str The string to search in
	 * @param string $search The character/string you are searching for
	 * @return int|null
	 */
	public function ReversePosition($search)
	{
		$result = strrpos($this->string, $search);
		return $result === false ? null : $result;
	}

	/**
	 * Performes string repeat
	 * If $multiply is lesser than 0, 0 will be taken
	 *
	 * @param string $string
	 * @param int $multiplier
	 * @return string
	 */
	public function Repeat($multiplier)
	{
		$multiplier = $multiplier > 0 ? $multiplier : 0;
		return str_repeat($this->string, $multiplier);
	}

	/**
	 * Generates an UUID
	 *
	 * @author     Anis uddin Ahmad <admin@ajaxray.com>
	 * @param      string  an optional prefix
	 * @return     string  the formatted uuid
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
	
}

?>
