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

final class TypeManager
{

	public static $classname = __CLASS__;
	private static $instance;
	private $types = array();

	private function __construct()
	{

	}

	private function __clone()
	{
		
	}

	/**
	 * @return TypeManager
	 */
	public static function Instance()
	{
		if(self::$instance === null)
			self::$instance = new self();
		return self::$instance;
	}

	public function getType($classname)
	{
		if(!array_key_exists($classname, $this->types))
			$this->types[$classname] = new Type($classname);

		return $this->types[$classname];
	}

}

?>