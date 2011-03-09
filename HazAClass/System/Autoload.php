<?php
/** * *******************************************************************************************************$
 * $Id:: Autoload.php 30 2010-11-14 17:41:29Z manuelgrundner                                                $
 * @author Manuel Grundner <m.grundner@delegate.at>,  René Grundner <r.grundner@delegate.at>                $
 * @copyright Copyright (c) 2008, Manuel Grundner & René Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package HazAClass                                                                                       $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-14 18:41:29 +0100 (So, 14 Nov 2010)                                           $
 * $LastChangedRevision:: 30                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/Autoload.php                 $
 * ********************************************************************************************************* */

namespace HazAClass\System;

use HazAClass\utils\StringUtil;
use HazAClass\core\checks\Natives;
use HazAClass\core\collections\NativeCollection;

include_once 'Object.php';
include_once 'String.php';

class Autoload extends Object
{

	/**
	 * The name of the class
	 * @var string
	 */
	public static $classname = __CLASS__;
	private $mainNameSpace;
	private $extension;
	private $frameworkPath;

	public function __construct($mainNameSpace, $basedir = __DIR__, $ext = 'php')
	{
		$this->mainNameSpace = $mainNameSpace.'\\';
		$this->extension = $ext;
		$this->frameworkPath = $basedir.\DIRECTORY_SEPARATOR;

		self::RegisterAutoloader($this);
	}

	public function GetMainNameSpace()
	{
		return $this->mainNameSpace;
	}

	public function GetExtension()
	{
		return $this->extension;
	}

	public function Load($classname)
	{
		$path = $this->BuildPath($classname);
		echo "Try to load:  $classname \n";
		echo "Loading path: $path \n";
		echo "Exists? ".var_export(file_exists($path),true)."\n";
		if(file_exists($path))
		{
			include($path);
			return true;
		}
		return false;
	}

	private function BuildPath($classname)
	{
		return String::Instance($this->frameworkPath)
			->Concat(
				String::Instance($classname)->Replace($this->mainNameSpace, ''), '.', $this->extension)
			->Replace('\\', DIRECTORY_SEPARATOR);
	}

	public static function RegisterAutoloader($classObj, $method = 'load')
	{
		self::Register(array($classObj, $method));
	}

	private static function Register($method)
	{
		spl_autoload_register($method);
	}

	public function GetFrameworkPath()
	{
		return $this->frameworkPath;
	}

	/**
	 * @param string $dir
	 * @return NativeCollection
	 */
	public static function LoadDir($dir, $ns)
	{
		$dirIt = new \DirectoryIterator($dir);
		$classes = new ArrayList();
		foreach($dirIt as $file)
			if($file->isFile())
			{
				include_once $file->getRealPath();
				$classes[] = $ns.'\\'.$file->getbaseName('.php');
			}
		return $classes;
	}
}

new Autoload('HazAClass', dirname(__DIR__));

?>