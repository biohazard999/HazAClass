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

use HazAClass\System\String;

class XmlAttribute extends XmlNode
{

	public static $classname = __CLASS__;
	protected $value;

	/**
	 *
	 * @param string $name
	 * @param string $value
	 * @param XmlNode $parentNode
	 */
	public function __construct($name, $value, XmlNode $parentNode = null)
	{
		$this->name = $name;
		$this->value = $value;
		$this->parentNode = $parentNode;
	}

	public function AddNode(XmlNode $node)
	{
		
	}

	public function RemoveNode(XmlNode $node)
	{
		
	}

	public function HasChildNodes()
	{
		return false;
	}

	public function SetParentNode(XmlNode $parentNode)
	{
		if($this->HasParentNode())
			$this->GetParentNode()->RemoveNode($this);

		$this->parentNode = $parentNode;
		$this->parentNode->AddNode($this);
	}

	public function Render()
	{
		$string = new String();
		$string->Concat($this->GetName(), '=', '"', $this->GetValue(), '"');
		return $string->ToString();
	}

}

?>
