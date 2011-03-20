<?php

/** ********************************************************************************************************$
 * $Id:: SessionCache.php 4 2010-11-06 12:37:02Z manuelgrundner                                             $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 *********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 ******************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-06 13:37:02 +0100 (Sa, 06 Nov 2010)                                           $
 * $LastChangedRevision:: 4                                                                                 $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/SessionCache.php       $
 ********************************************************************************************************** */

namespace HazAClass\core\cache;

use HazAClass\core\debug\Debug;
use HazAClass\core\config\system\cache\SessionCacheConfig;

/**
 *
 */
class SessionCache extends AbstractBaseCache
{

    public static $classname = __CLASS__;
    private $tablename;

    function __construct(SessionCacheConfig $config)
    {
        $this->tablename = $config->getTablename();
		if(!array_key_exists($this->tablename, $_SESSION))
			$_SESSION[$this->tablename] = array();
    }

    protected function getValueFromStorage($name)
    {
		if($this->isStored($name))
			return $_SESSION[$this->tablename][$name]['value'];

		return null;
    }

    protected function getTimeFromStorage($name)
    {
		if($this->isStored($name))
			return $_SESSION[$this->tablename][$name]['expireTime'];


		return null;
    }

    protected function storeToStorage($name, $value, $expireTime)
    {
		$_SESSION[$this->tablename][$name] = array(
			'value' => $value,
			'expireTime' => $expireTime,
		);
    }

	private function isStored($name)
	{
		return array_key_exists($name, $_SESSION[$this->tablename]);
   	}

    public function cleanUp()
    {
		foreach($_SESSION[$this->tablename] as $name => $stored)
			if($stored['expireTime'] < time())
				unset($_SESSION[$this->tablename][$name]);
    }

}
?>
