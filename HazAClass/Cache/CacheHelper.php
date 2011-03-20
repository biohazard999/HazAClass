<?php

/** * *******************************************************************************************************$
 * $Id:: CacheHelper.php 103 2011-01-25 08:59:46Z manuelgrundner                                            $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/CacheHelper.php        $
 * ********************************************************************************************************* */

namespace HazAClass\core\cache;

use HazAClass\utils\HashUtil;
use HazAClass\core\debug\Debug;

abstract class CacheHelper
{

	public static $classname = __CLASS__;

	public static function checkFileChange(iCacheProvider $cache, $fileName)
	{
		if($cache->isEnabled())
		{
			try
			{
				if(!HashUtil::compareFile($cache->getValue($fileName), $fileName))
					$cache->invalidate($fileName);
			}
			catch(CacheInvalidatedException $e)
			{
				$cache->store($fileName, HashUtil::createFileHash($fileName), iCacheProvider::NEVER);
				throw $e;
			}
		}
	}

}

?>
