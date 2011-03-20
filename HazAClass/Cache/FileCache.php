<?php
/** * *******************************************************************************************************$
 * $Id:: FileCache.php 4 2010-11-06 12:37:02Z manuelgrundner                                                $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/FileCache.php          $
 * ********************************************************************************************************* */

namespace HazAClass\core\cache;

use HazAClass\core\config\system\cache\FileCacheConfig;
use HazAClass\core\system\storage\Directory;
use HazAClass\core\debug\Debug;

class FileCache extends AbstractBaseCache
{

	public static $classname = __CLASS__;
	private $config;
	/**
	 * @var Directory
	 */
	private $cacheDir;

	public function __construct(FileCacheConfig $config)
	{
		$this->config = $config;
		$this->cacheDir = new Directory($config->path);
	}

	protected function getTimeFromStorage($name)
	{
		return $this->cacheDir->getFile($name)->getLastModifiedTime();
	}

	protected function getValueFromStorage($name)
	{
		return $this->cacheDir->getFile($name)->getContent();
	}

	protected function storeToStorage($name, $value, $expireTime)
	{
		$file = null;
		if($this->stored($name))
			$file = $this->cacheDir->getFile($name);
		else
			$file = $this->cacheDir->createFile($name);

		$file->setContent($value);
		$file->save();
	}

	public function cleanUp()
	{
		foreach($this->cacheDir->getFiles() as $cacheFile)/* @var $cacheFile File */
			$cacheFile->delete();
	}

}
?>