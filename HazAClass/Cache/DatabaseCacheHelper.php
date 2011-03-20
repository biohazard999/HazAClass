<?php

/** ********************************************************************************************************$
 * $Id:: DatabaseCacheHelper.php 4 2010-11-06 12:37:02Z manuelgrundner                                      $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/DatabaseCacheHelper.ph#$
 ********************************************************************************************************** */

namespace HazAClass\core\cache;

use HazAClass\utils\StringUtil;

abstract class DatabaseCacheHelper
{

    public static $classname = __CLASS__;

	/**
	 * Dirty work around for encoding a UTF8 generated PHP-Files
	 * @param string $string
	 * @return string
	 */
    public static function encodeNullCharacter($string)
    {
        return StringUtil::replace($string, "\0", "~~NULL_BYTE~~");
    }

	/**
	 * Dirty work around for decoding a UTF8 generated PHP-Files
	 * @param string $string
	 * @return string
	 */
    public static function decodeNullCharacter($string)
    {
        return StringUtil::replace($string, "~~NULL_BYTE~~", "\0");
    }

}
?>
