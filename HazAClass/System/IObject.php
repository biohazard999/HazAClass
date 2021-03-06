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

include_once 'IStringCastAble.php';

interface IObject extends IStringCastAble
{

	const IObject = __CLASS__;

	/**
	 * @return string The corresponding Hashcode of the object (spl_object_hash)
	 */
	public function GetHash();
	
	/**
	 * @return Type Returns the TypeObject
	 */
	public function GetType();
	
	/**
	 * @return string Returns the classname of the object
	 */
	public function GetClassName();

	public function ReferenceEquals(IObject $obj);

}

?>
