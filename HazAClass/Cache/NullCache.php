<?php
/** * *******************************************************************************************************$
 * $Id:: NullCache.php 4 2010-11-06 12:37:02Z manuelgrundner                                                $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/NullCache.php          $
 * ********************************************************************************************************* */

namespace HazAClass\core\cache;

class NullCache extends AbstractBaseCache
{

	public static $classname = __CLASS__;

	protected function getTimeFromStorage($name)
	{
		return null;
	}

	protected function getValueFromStorage($name)
	{
		$this->invalidate($name);
	}

	protected function storeToStorage($name, $value, $expireTime)
	{
		return null;
	}

	public function cleanUp()
	{
		return null;
	}

}
?>
