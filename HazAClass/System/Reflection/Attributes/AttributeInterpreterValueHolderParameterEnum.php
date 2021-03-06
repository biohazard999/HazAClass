<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeInterpreterValueHolderParameterEnum.php 4 2010-11-06 12:37:02Z manuelgrundner             $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AttributeInterpre#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection\Attributes;

class AttributeInterpreterValueHolderParameterEnum extends AbstractAttributeInterpreterValueHolderParameterComplex
{

	public static $classname = __CLASS__;
	private $enumType;

	public function GetEnumType()
	{
		return $this->enumType;
	}

	public function SetEnumType($enumType)
	{
		$this->enumType = $enumType;
	}

	public function GetShortName()
	{
		return $this->GetEnumType();
	}

	public function SetShortName($shortName)
	{
		$this->SetEnumType($shortName);
	}

}

?>
