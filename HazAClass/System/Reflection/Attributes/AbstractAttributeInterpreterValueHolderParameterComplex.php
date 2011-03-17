<?php
/** ********************************************************************************************************$
 * $Id:: AbstractAttributeInterpreterValueHolderParameterComplex.php 4 2010-11-06 12:37:02Z manuelgrundner  $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/attributes/AbstractAttribute#$
 ***********************************************************************************************************/

namespace HazAClass\System\Reflection\Attributes;

abstract class AbstractAttributeInterpreterValueHolderParameterComplex extends AbstractAttributeInterpreterValueHolderParameter
{

	public static $classname = __CLASS__;
	private $fullQualifiedName;

	public function getFullQualifiedName()
	{
		return $this->fullQualifiedName;
	}

	public function setFullQualifiedName($fullQualifiedName)
	{
		$this->fullQualifiedName = $fullQualifiedName;
	}

	abstract public function getShortName();
	abstract public function setShortName($shortName);

}


?>
