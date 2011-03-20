<?php

/** * *******************************************************************************************************$
 * $Id:: RevivedAttribute.php 19 2010-11-08 01:51:07Z manuelgrundner                                        $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-08 02:51:07 +0100 (Mo, 08 Nov 2010)                                           $
 * $LastChangedRevision:: 19                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/RevivedAttribute.php     $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

use HazAClass\System\Attribute;

class RevivedAttribute extends Attribute
{

	public static $classname = __CLASS__;
	private $revidedMethod;

	public function __construct($revidedMethod = 'revived')
	{
		$this->revidedMethod = $revidedMethod;
	}

	public function GetRevidedMethod()
	{
		return $this->revidedMethod;
	}


}

?>
