<?php
/** * *******************************************************************************************************$
 * $Id:: SummonAttribute.php 15 2010-11-08 00:48:00Z manuelgrundner                                         $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-08 01:48:00 +0100 (Mo, 08 Nov 2010)                                           $
 * $LastChangedRevision:: 15                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/SummonAttribute.php      $
 * ********************************************************************************************************* */

namespace HazAClass\Evocator;

use HazAClass\System\Attribute;
use HazAClass\System\Type;

class SummonAttribute extends Attribute
{

	public static $classname = __CLASS__;
	private $spellType;
	public $Name;
	public $Optional;

	public function __construct($spellType)
	{
		if(!($spellType instanceof Type))
			$spellType = typeof($spellType);
		$this->spellType = $spellType;
	}

	/**
	 * @return Type
	 */
	public function GetSpellType()
	{
		return $this->spellType;
	}

	public function GetName()
	{
		return $this->Name;
	}

	public function IsNamedCreature()
	{
		return $this->Name !== null;
	}

	public function IsOptional()
	{
		return $this->Optional;
	}

}

?>
