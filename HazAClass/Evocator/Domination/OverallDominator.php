<?php
/** ********************************************************************************************************$
 * $Id:: OverallDominator.php 23 2010-11-09 16:49:23Z manuelgrundner                                        $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 *********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 ******************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-09 17:49:23 +0100 (Di, 09 Nov 2010)                                           $
 * $LastChangedRevision:: 23                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/Evocator/domination/OverallDomina#$
 ***********************************************************************************************************/

namespace HazAClass\Evocator\Domination;

if(session_id() === '')
	session_start();

/**
 * This Dominator provides a Sessionbased lifetime of objects
 * For the whole session-lifetime the same object is returned
 */
class OverallDominator extends AbstractDominator
{

	public static $classname = __CLASS__;
	private $sessionArray;

	public function __construct(array &$sessionArray)
	{
		$this->sessionArray = $sessionArray;
	}

	public function dominateCreature()
	{
		if($this->creature === null)
		{
			if(array_key_exists(__CLASS__, $this->sessionArray) && array_key_exists($this->creatureClassname, $this->sessionArray[__CLASS__]))
				return $this->creature = unserialize($this->sessionArray[__CLASS__][$this->creatureClassname]);

			$this->creature = $this->getSummoner()->summon();
		}
		return $this->creature;
	}

	public function __destruct()
	{
		$this->sessionArray[__CLASS__][$this->creatureClassname] = serialize($this->summonCreature());
	}
}

?>
