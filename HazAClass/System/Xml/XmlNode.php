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

use HazAClass\System\IRenderble;
use HazAClass\System\Collection\FilterIterator;
use HazAClass\System\Object;
use HazAClass\System\Collection\Generic\GenericList;

abstract class XmlNode extends Object implements IRenderble, \Countable
{

	public static $classname = __CLASS__;
	protected $name;
	/**
	 * @var GenericList
	 */
	protected $nodes;
	/**
	 * @var XmlNode
	 */
	protected $parentNode;

	public function AddNode(XmlNode $node)
	{
		if($node->HasParentNode() && !$node->GetParentNode()->ReferenceEquals($this) || !$node->HasParentNode())
		{
			$node->SetParentNode($this);

			$this->nodes[] = $node;
		}
	}

	public function RemoveNode(XmlNode $node)
	{
		$this->nodes->Remove($node);
	}

	public function SetParentNode(XmlNode $parentNode)
	{
		if(!$this->HasParentNode() || !$this->parentNode->ReferenceEquals($parentNode))
		{
			$this->parentNode = $parentNode;
			$this->parentNode->AddNode($this);
		}
	}

	/**
	 * @return XmlNode
	 */
	public function GetParentNode()
	{
		return $this->parentNode;
	}

	public function HasParentNode()
	{
		return $this->parentNode !== null;
	}

	public function HasChildNodes()
	{
		return $this->count() > 0;
	}

	public function GetName()
	{
		return $this->name;
	}

	public function SetName($name)
	{
		$this->name = $name;
	}

	public function Render()
	{
		$string = new String('<');
		$string->Concat($this->GetName());

		$it = new FilterIterator($this->nodes, new TypeFilter(typeof(XmlAttribute::$classname)));
		foreach($it as $attribute)
			$string->Concat(String::SPACE_STRING, $attribute->Render());

		if($this->HasChildNodes())
		{
			$string->Concat('>');

			$it = new FilterIterator($this->nodes, new TypeFilter(typeof(XmlElement::$classname)));
			foreach($it as $attribute)
				$string->Concat($attribute->Render());

			$string->Concat('</', $this->GetName(), '>');
		}
		else
			$string->Concat(String::SPACE_STRING, '/>');

		return $string->ToString();
	}

	public function count()
	{
		return $this->nodes->count();
	}

}

?>
