<?php
/** * *******************************************************************************************************$
 * $Id:: AttributeInterpreterValueHolderParameterClassConstant.php 4 2010-11-06 12:37:02Z manuelgrundner    $
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

class AttributeInterpreterValueHolderParameterClassConstant extends AbstractAttributeInterpreterValueHolderParameterComplex
{

	public static $classname = __CLASS__;
	private $constantName;

	public function GetConstantName()
	{
		return $this->constantName;
	}

	public function SetConstantName($constantName)
	{
		$this->constantName = $constantName;
	}

	public function GetShortName()
	{
		return $this->GetConstantName();
	}

	public function SetShortName($shortName)
	{
		$this->SetConstantName($shortName);
	}

}

?>
