<?php
namespace HazAClass\System\TestAttributes;

use HazAClass\System\Attribute;


class TestNamedAttribute extends Attribute
{
    public static $classname = __CLASS__;

    public $stringVar;
    public $intVar;
    public $doubleVar;
    public $enumVar;
    public $boolVar;
    public $staticVar;
    public $constVar;
}

?>
