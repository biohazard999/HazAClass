<?php

namespace HazAClass\System\Reflection\TestAttributes;

interface ITestAttribute
{

	public function getStringVar();

	public function getIntVar();

	public function getDoubleVar();

	public function getEnumVar();

	public function getBoolVar();

	public function getStaticVar();

	public function getConstVar();
}

?>
