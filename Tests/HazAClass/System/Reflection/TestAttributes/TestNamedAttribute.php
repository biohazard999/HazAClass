<?php

namespace HazAClass\System\Reflection\TestAttributes;

use HazAClass\System\Attribute;

class TestNamedAttribute extends Attribute implements ITestAttribute
{

	public static $classname = __CLASS__;
	public $stringVar;
	public $intVar;
	public $doubleVar;
	public $enumVar;
	public $boolVar;
	public $staticVar;
	public $constVar;

	public function getStringVar()
	{
		return $this->stringVar;
	}

	public function getIntVar()
	{
		return $this->intVar;
	}

	public function getDoubleVar()
	{
		return $this->doubleVar;
	}

	public function getEnumVar()
	{
		return $this->enumVar;
	}

	public function getBoolVar()
	{
		return $this->boolVar;
	}

	public function getStaticVar()
	{
		return $this->staticVar;
	}

	public function getConstVar()
	{
		return $this->constVar;
	}

}

?>
