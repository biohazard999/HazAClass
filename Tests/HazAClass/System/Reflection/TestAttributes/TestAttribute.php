<?php

namespace HazAClass\System\Reflection\TestAttributes;

use HazAClass\System\Attribute;

class TestAttribute extends Attribute implements ITestAttribute {

    public static $classname = __CLASS__;
    private $stringVar;
    private $intVar;
    private $doubleVar;
    private $enumVar;
    private $boolVar;
    private $staticVar;
    private $constVar;

    public function __construct($stringVar, $intVar, $doubleVar, TestEnum $enumVar, $boolVar, $staticVar, $constVar) {
        $this->stringVar = $stringVar;
        $this->intVar = $intVar;
        $this->doubleVar = $doubleVar;
        $this->enumVar = $enumVar;
        $this->boolVar = $boolVar;
        $this->staticVar = $staticVar;
        $this->constVar = $constVar;
    }

    public function getStringVar() {
        return $this->stringVar;
    }

    public function getIntVar() {
        return $this->intVar;
    }

    public function getDoubleVar() {
        return $this->doubleVar;
    }

    public function getEnumVar() {
        return $this->enumVar;
    }

    public function getBoolVar() {
        return $this->boolVar;
    }

    public function getStaticVar() {
        return $this->staticVar;
    }

    public function getConstVar() {
        return $this->constVar;
    }

}

?>
