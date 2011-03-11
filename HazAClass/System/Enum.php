<?php

/** * *******************************************************************************************************$
 * $Id:: Enum.php 30 2010-11-14 17:41:29Z manuelgrundner                                                    $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-14 18:41:29 +0100 (So, 14 Nov 2010)                                           $
 * $LastChangedRevision:: 30                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/type/Enum.php                $
 * ********************************************************************************************************* */

namespace HazAClass\System;

abstract class Enum extends Object
{
	public static $classname = __CLASS__;

	protected $value;

	private static $instances = array();

	private function __construct($value)
	{
		$this->value = $value;
	}

	/**
	 * @param string $methodHash
	 * @return Enum
	 */
	protected static function getInstance($value)
	{
		$methodHash = hash('md5', $value);
		if(!array_key_exists(static::$classname, self::$instances))
			self::$instances[static::$classname] = array();

		if(!array_key_exists($methodHash, self::$instances[static::$classname]))
			self::$instances[static::$classname][$methodHash] = new static($value);

		return self::$instances[static::$classname][$methodHash];
	}

	public function getValue()
	{
		return $this->value;
	}

	public function ToString()
	{
		return (string) $this->value;
	}
}

?>
