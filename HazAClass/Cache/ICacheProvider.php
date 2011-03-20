<?php
/** * *******************************************************************************************************$
 * $Id:: iCacheProvider.php 4 2010-11-06 12:37:02Z manuelgrundner                                           $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/iCacheProvider.php     $
 * ********************************************************************************************************* */

namespace HazAClass\core\cache;

use HazAClass\System\DateTime;

interface ICacheProvider
{

	public function Invalidated($name);

	public function Invalidate($name);

	public function GetValue($name);

	public function Store($name, $value, DateTime $expireTime = null);

	public function CleanUp();

	public function Disable();

	public function Enable();

	public function IsEnabled();
}

?>
