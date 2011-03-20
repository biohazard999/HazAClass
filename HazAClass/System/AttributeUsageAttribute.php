<?php

/** * *******************************************************************************************************$
 * $Id:: AttributeUsageAttribute.php 48 2010-11-28 09:03:29Z manuelgrundner                                 $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-28 10:03:29 +0100 (So, 28 Nov 2010)                                           $
 * $LastChangedRevision:: 48                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeUsageAtt#$
 * ********************************************************************************************************* */

namespace HazAClass\System;

class AttributeUsageAttribute extends Attribute
{

	public static $classname = __CLASS__;
	private $attributeUsage;
	private $attributeInheritance;

	public function __construct(AttributeUsage $attributeUsage, AttributeInheritance $inheritance = null)
	{
		if($inheritance === null)
			$inheritance = AttributeInheritance::NotInherited();
		$this->attributeUsage = $attributeUsage;
		$this->attributeInheritance = $inheritance;
	}

	/**
	 * @return AttributeUsage
	 */
	public function GetAttributeUsage()
	{
		return $this->attributeUsage;
	}

	/**
	 * @return AttributeInheritance
	 */
	public function GetAttributeInheritance()
	{
		return $this->attributeInheritance;
	}

}

?>
