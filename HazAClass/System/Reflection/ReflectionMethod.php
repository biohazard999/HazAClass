<?php
/** * *******************************************************************************************************$
 * $Id:: ReflectionMethod.php 4 2010-11-06 12:37:02Z manuelgrundner                                         $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/reflection/ReflectionMethod.#$
 * ********************************************************************************************************* */

namespace HazAClass\System\Reflection;

use HazAClass\System\Reflection\Attributes\AttributeBuilder;


class ReflectionMethod extends \ReflectionMethod
{

	public static $classname = __CLASS__;
	private $attributes;

	public function HasAttribute($name)
	{
		return $this->getAttributes()->hasIndex($name);
	}

	public function GetAttribute($name)
	{
		return $this->getAttributes()->get($name);
	}

	/**
	 * @return IList
	 */
	public function GetAttributes()
	{
		if($this->attributes === null)
		{
			$builder = new AttributeBuilder($this);
			$this->attributes = $builder->getAttributes();
		}
		return $this->attributes;
	}

	public function getDeclaringClass()
	{
		$class = parent::getDeclaringClass();
		return new ReflectionClass($class->getName());
	}
}

?>
