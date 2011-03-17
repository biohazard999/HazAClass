<?php

namespace HazAClass\System\Reflection\TestAttributes;

use HazAClass\System\Attribute;

class TestMixedAttribute extends Attribute
{

	public static $classname = __CLASS__;
	private $stringVar;
	private $intVar;
	private $doubleVar;
	public $enumVar;
	public $boolVar;
	public $staticVar;
	public $constVar;

	public function __construct($stringVar, $intVar, $doubleVar)
	{
		$this->stringVar = $stringVar;
		$this->intVar = $intVar;
		$this->doubleVar = $doubleVar;
	}

}

?>
