<?php
/** ********************************************************************************************************$
 * $Id:: AbstractAttributeInterpreterValueHolderParameter.php 4 2010-11-06 12:37:02Z manuelgrundner         $
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

namespace HazAClass\core\attributes;


abstract class AbstractAttributeInterpreterValueHolderParameter
{

	public static $classname = __CLASS__;
	private $name;
	private $isNamed = false;
	private $value;

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;
		$this->isNamed = $name !== null;
	}

	public function isNamed()
	{
		return $this->isNamed;
	}

	public function getValue()
	{
		return $this->value;
	}

	public function setValue($value)
	{
		$this->value = $value;
	}

}


?>
