<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeInterpreterValueHolderParameterStaticProperty.php 4 2010-11-06 12:37:02Z manuelgrundner   $
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

namespace HazAClass\System\Attributes;

use HazAClass\System\String;

class AttributeInterpreterValueHolderParameterStaticProperty extends AbstractAttributeInterpreterValueHolderParameterComplex
{

	public static $classname = __CLASS__;
	private $propertyName;

	public function GetPropertyName()
	{
		return $this->propertyName;
	}

	public function SetPropertyName($constantName)
	{
		$this->propertyName = $constantName;
	}

	public function GetShortName()
	{
		return $this->GetPropertyName();
	}

	public function SetShortName($shortName)
	{
		$this->SetPropertyName($shortName);
	}

	public function GetValue()
	{
		return String::Instance(parent::getValue())->RemoveBegin('$')->ToString();
	}
}

?>
