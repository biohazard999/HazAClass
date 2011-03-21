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

namespace HazAClass\System\Xml;

use HazAClass\System\Object;
use HazAClass\System\IRenderble;

class XmlDocument extends Object implements IRenderble
{

	public static $classname = __CLASS__;
	/**
	 * @var XmlElement
	 */
	private $rootElement;

	public function __construct(XmlElement $rootElement = null)
	{
		$this->rootElement = $rootElement;
	}

	/**
	 * @return XmlElement
	 */
	public function GetRootNode()
	{
		return $this->rootElement;
	}

	public function SetRootNode(XmlElement $rootElement)
	{
		$this->rootElement = $rootElement;
	}

	public function Render()
	{
		$string = new String('<?xml version="1.0" encoding="UTF-8" ?>', String::NEW_LINE);
		if($this->rootElement !== null)
			$string->Concat($this->rootElement->Render());
		return $string->ToString();
	}

	public function ToString()
	{
		return $this->Render();
	}

}

?>
	