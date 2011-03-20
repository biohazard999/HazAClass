<?php

namespace HazAClass\Evocator;

require_once dirname(__FILE__).'/../../../HazAClass/Evocator/Evocator.php';

/**
 * Test class for Evocator.
 * Generated by PHPUnit on 2011-03-20 at 07:50:57.
 */
class EvocatorTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Evocator
	 */
	protected $evocator;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->evocator = new Evocator();
	}

	protected function tearDown()
	{
		$this->evocator = null;
	}


	// <editor-fold defaultstate="collapsed" desc=" Normal Summon ">
	public function testSummonNormalClassInterfaceNotImplemented()
	{
		$this->setExpectedException(LearnSpellException::$classname);
		$this->evocator->learnSpell(iTest::iTest, TestClassWithoutITest::$classname);
	}

	public function testSummonNormalClass()
	{
		$this->evocator->learnSpell(iTest::iTest, NormalTestClass::$classname);
		$this->assertType(NormalTestClass::$classname, $this->evocator->summon(iTest::iTest));
	}

	public function testAutoSummonClass()
	{
		$this->assertType(NormalTestClass::$classname, $this->evocator->summon(NormalTestClass::$classname));
	}

	public function testAutoSummonInterfaceClass()
	{
		$this->evocator->learnSpell(iTestDependency::iTestDependency, InterfaceTestDependency::$classname);

		$this->assertType(iTest::iTest, $this->evocator->summon(InterfaceTestClass::$classname));
	}

	public function testFailAutoSummonInterfaceClass()
	{
		$this->setExpectedException(SummonException::$classname);
		$this->evocator->summon(InterfaceTestClass::$classname);
	}

	public function testAutoSummonClassTypeMapException()
	{
		$this->setExpectedException(AutoSummonException::$classname, AutoSummonException::INTERFACE_COULD_NOT_BE_AUTO_SUMMOND);
		$this->evocator->summon(iTest::iTest);
	}

	/**
	 * @todo Implement testCreateNoviceEvocator().
	 */
	public function testCreateNoviceEvocator()
	{
		$this->assertType(Evocator::$classname, $this->evocator->createNoviceEvocator());
	}

	public function testScalarFailSummon()
	{
		$this->setExpectedException(SummonException::$classname);
		$this->evocator->summon(ScalarParamTestClass::$classname);
	}

	public function testArrayFailSummon()
	{
		$this->setExpectedException(SummonException::$classname);
		$this->evocator->summon(ArrayParamTestClass::$classname);
	}

	public function testArrayOptionalSuccessSummon()
	{
		$this->assertType(ArrayOptionalParamTestClass::$classname, $this->evocator->summon(ArrayOptionalParamTestClass::$classname));
	}

	public function testNullableInjectionSuccess()
	{
		$this->evocator->learnSpell(iTestDependency::iTestDependency, InterfaceTestDependency::$classname);

		$testObject = $this->evocator->summon(ClassNullableParamTestClass::$classname); /* @var $testObject ClassNullableParamTestClass */

		$this->assertType(iTestDependency::iTestDependency, $testObject->getTestDependency());
	}

	public function testNullableInjectionNull()
	{
		$testObject = $this->evocator->summon(ClassNullableParamTestClass::$classname); /* @var $testObject ClassNullableParamTestClass */
		$this->assertEquals(null, $testObject->getTestDependency());
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Posses Summon ">
	public function testPossessCreatureDefaultLifetimeManagerNoInterface()
	{
		$object = new TestClassWithoutITest;

		$this->evocator->possessCreature(TestClassWithoutITest::$classname, $object);
		$this->assertEquals($object, $this->evocator->summon(TestClassWithoutITest::$classname));
	}

	public function testPossessCreatureDefaultLifetimeManager()
	{
		$object = $this->evocator->summon(NormalTestClass::$classname);

		$this->evocator->possessCreature(NormalTestClass::$classname, $object);
		$this->assertEquals($object, $this->evocator->summon(NormalTestClass::$classname));
	}

	public function testPossessCreatureDefaultLifetimeManagerNormalCreation()
	{
		$object = new NormalTestClass(new NormalTestDependency());

		$this->evocator->possessCreature(NormalTestClass::$classname, $object);
		$this->assertEquals($object, $this->evocator->summon(NormalTestClass::$classname));
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Method Summon">

	public function testPrivateMethodSummon()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$this->evocator->summon(PrivateMethodClass::$classname);
	}

	public function testProtectedMethodSummon()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$this->evocator->summon(ProtectedMethodClass::$classname);
	}

	public function testEmptyMethodSummon()
	{
		$this->assertTrue($this->evocator->summon(EmptyMethodSummon::$classname)->isSummoned());
	}

	public function testNormalMethodSummon()
	{
		$this->assertType(NormalTestDependency::$classname, $this->evocator->summon(NormalMethodSummon::$classname)->getDependency());
	}

	public function testNoMethodSummon()
	{
		$this->assertFalse($this->evocator->summon(EmptyMethodNoSummon::$classname)->isSummoned());
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Property Summon ">
	public function testNormalPropertySummon()
	{
		$prop = $this->evocator->summon(NormalPropertyClass::$classname); /* @var $prop NormalPropertyClass */
		$this->assertType(NormalTestDependency::$classname, $prop->property);
	}

	public function testPrivatePropertySummon()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$this->evocator->summon(PrivatePropertyClass::$classname);
	}

	public function testProtectedPropertySummon()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$this->evocator->summon(ProtectedPropertyClass::$classname);
	}

	public function testOptionalFailPropertySummon()
	{
		$prop = $this->evocator->summon(NormalOptionalPropertyClass::$classname); /* @var $prop iTestDependency */
		$this->assertEquals(null, $prop->property);
	}

	public function testOptionalSuccessPropertySummon()
	{
		$this->evocator->learnSpell(iTestDependency::iTestDependency, InterfaceTestDependency::$classname);
		$prop = $this->evocator->summon(NormalOptionalPropertyClass::$classname); /* @var $prop iTestDependency */
		$this->assertType(iTestDependency::iTestDependency, $prop->property);
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Forget Spells ">
	public function testForgetSpell()
	{
		$this->evocator->learnSpell(iTest::iTest, NormalTestClass::$classname);
		$this->assertType(iTest::iTest, $this->evocator->summon(iTest::iTest));
		$this->evocator->forgetSpell(iTest::iTest);
		$this->assertFalse($this->evocator->hasSpell(iTest::iTest));
	}

	public function testForgetSpellNamed()
	{
		$this->evocator->learnSpell(iTest::iTest, NormalTestClass::$classname, 'testname');
		$this->assertType(iTest::iTest, $this->evocator->summon(iTest::iTest, 'testname'));
		$this->evocator->forgetSpell(iTest::iTest, 'testname');
		$this->assertFalse($this->evocator->hasSpell(iTest::iTest, 'testname'));
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Summon All ">
	public function testSummonAll()
	{
		$this->evocator->learnSpell(iTestDependency::iTestDependency, InterfaceTestDependency::$classname);
		$this->evocator->learnSpell(iTest::iTest, NormalTestClass::$classname, 'normal');
		$this->evocator->learnSpell(iTest::iTest, InterfaceTestClass::$classname, 'interface');

		$creatures = $this->evocator->summonAll(iTest::iTest);

		$this->assertEquals(2, $creatures->count());

		$this->assertType(NormalTestClass::$classname, $creatures['normal']);
		$this->assertType(InterfaceTestClass::$classname, $creatures['interface']);
	}

	public function testSummonAllWithUnnamed()
	{
		$this->evocator->learnSpell(iTestDependency::iTestDependency, InterfaceTestDependency::$classname);
		$this->evocator->learnSpell(iTest::iTest, MultipleTestClass::$classname);
		$this->evocator->learnSpell(iTest::iTest, NormalTestClass::$classname, 'normal');
		$this->evocator->learnSpell(iTest::iTest, InterfaceTestClass::$classname, 'interface');

		$creatures = $this->evocator->summonAll(iTest::iTest);

		$this->assertEquals(2, $creatures->count());

		$this->assertType(NormalTestClass::$classname, $creatures['normal']);
		$this->assertType(InterfaceTestClass::$classname, $creatures['interface']);
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Dominations ">
	public function testEvocatorLifeTimeManager()
	{
		$this->evocator->learnSpell(iTest::iTest, NormalTestClass::$classname, null, new EvocatorDominator());

		$object = $this->evocator->summon(iTest::iTest);

		$this->assertEquals($object, $this->evocator->summon(iTest::iTest));
	}

	public function testEvocatorLifeTimeManagerNamed()
	{
		$this->evocator->learnSpell(iTest::iTest, NormalTestClass::$classname, 'name', new EvocatorDominator());

		$object = $this->evocator->summon(iTest::iTest, 'name');

		$this->assertEquals($object, $this->evocator->summon(iTest::iTest, 'name'));
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Revive Creature">
	public function testDefaultRevived()
	{
		$obj = $this->evocator->summon(DefaultRevivedClass::$classname); /* @var $obj DefaultRevivedClass */
		$this->assertTrue($obj->isRevived());
	}

	public function testRevivedPrivateFail()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$obj = $this->evocator->summon(PrivateRevivedClass::$classname);
	}

	public function testRevivedProtectedFail()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$obj = $this->evocator->summon(ProtectedRevivedClass::$classname);
	}

	public function testCustomRevived()
	{
		$obj = $this->evocator->summon(CustomRevivedClass::$classname); /* @var $obj CustomRevivedClass */
		$this->assertTrue($obj->isRevived());
	}

	public function testCustomRevivedFail()
	{
		$this->setExpectedException(SummonException::$classname);
		$this->evocator->summon(CustomRevivedFailClass::$classname);
	}

	// </editor-fold>
	// <editor-fold defaultstate="collapsed" desc=" Self Injection ">
	public function testSelfInjection()
	{
		$this->evocator->possessCreature(Evocator::$classname, $this->evocator);
		$this->assertEquals($this->evocator, $this->evocator->summon(SelfInjection::$classname)->getEvocator());
	}

	public function testSelfInjectionMethod()
	{
		$this->evocator->possessCreature(Evocator::$classname, $this->evocator);
		$this->assertEquals($this->evocator, $this->evocator->summon(SelfInjectionMethod::$classname)->getEvocator());
	}

	public function testSelfInjectionProperty()
	{
		$this->evocator->possessCreature(Evocator::$classname, $this->evocator);
		$this->assertEquals($this->evocator, $this->evocator->summon(SelfInjectionProperty::$classname)->getEvocator());
	}

	// </editor-fold>

	public function testEnchantException()
	{
		$this->setExpectedException(SummonException::$classname, SummonException::COULD_NOT_ENCHANT_CREATUE);
		$this->evocator->enchant('Fail');
	}

	public function testEnchantingMethod()
	{
		$creature = new SelfInjectionMethod();
		$this->assertEquals(null, $creature->getEvocator());
		$this->evocator->possessCreature(Evocator::$classname, $this->evocator);
		$this->evocator->enchant($creature);
		$this->assertEquals($this->evocator, $creature->getEvocator());
	}

	public function testEnchantingProperties()
	{
		$creature = new SelfInjectionProperty();
		$this->assertEquals(null, $creature->getEvocator());
		$this->assertFalse($creature->isEnchanted());
		$this->evocator->possessCreature(Evocator::$classname, $this->evocator);
		$this->evocator->enchant($creature);
		$this->assertEquals($this->evocator, $creature->getEvocator());
		$this->assertTrue($creature->isEnchanted());
	}

	public function testFailEnchantingMethod()
	{
		$this->setExpectedException(SummonException::$classname, sprintf(SummonException::ENCHANT_METHOD_DOES_NOT_EXIST, 'enchanted', FailEnchantMethod::$classname));
		$creature = new FailEnchantMethod();

		$this->evocator->enchant($creature);
	}

	public function testEnchantingPrivateFail()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$creature = new FailEnchantMethodPrivate();
		$this->evocator->enchant($creature);
	}

	public function testEnchantingProtectedFail()
	{
		$this->setExpectedException('\\PHPUnit_Framework_Error_Warning');
		$creature = new FailEnchantMethodProtected();
		$this->evocator->enchant($creature);
	}

}

/**
 * @Enchanted
 */
class FailEnchantMethodPrivate
{

	public static $classname = __CLASS__;

	private function enchanted()
	{
		
	}

}

/**
 * @Enchanted
 */
class FailEnchantMethodProtected
{

	public static $classname = __CLASS__;

	private function enchanted()
	{
		
	}

}

/**
 * @Enchanted
 */
class FailEnchantMethod
{

	public static $classname = __CLASS__;

}

// <editor-fold defaultstate="collapsed" desc=" Test Classes ">
class SelfInjection
{

	public static $classname = __CLASS__;
	private $evocator;

	public function __construct(Evocator $evocator)
	{
		$this->evocator = $evocator;
	}

	public function getEvocator()
	{
		return $this->evocator;
	}

}

/**
 * @Enchanted
 */
class SelfInjectionMethod
{

	public static $classname = __CLASS__;
	private $evocator;
	private $isEnchanted = false;

	/**
	 * @Summon
	 */
	public function method(Evocator $evocator)
	{
		$this->evocator = $evocator;
	}

	public function getEvocator()
	{
		return $this->evocator;
	}

	public function enchanted()
	{
		$this->isEnchanted = true;
	}

	public function isEnchanted()
	{
		return $this->isEnchanted;
	}

}

/**
 * @Enchanted
 */
class SelfInjectionProperty
{

	public static $classname = __CLASS__;
	/**
	 * @Summon
	 * @SummonType(Evocator::$classname)
	 */
	public $evocator;
	private $isEnchanted = false;
	public function getEvocator()
	{
		return $this->evocator;
	}

	public function enchanted()
	{
		$this->isEnchanted = true;
	}

	public function isEnchanted()
	{
		return $this->isEnchanted;
	}

}

/**
 * @Revived('notExistingMethod')
 */
class CustomRevivedFailClass
{

	public static $classname = __CLASS__;

}

/**
 * @Revived
 */
class DefaultRevivedClass
{

	public static $classname = __CLASS__;
	private $revived = false;

	public function revived()
	{
		$this->revived = true;
	}

	public function isRevived()
	{
		return $this->revived;
	}

}

/**
 * @Revived('customRevived')
 */
class CustomRevivedClass
{

	public static $classname = __CLASS__;
	private $revived = false;

	public function customRevived()
	{
		$this->revived = true;
	}

	public function isRevived()
	{
		return $this->revived;
	}

}

/**
 * @Revived
 */
class PrivateRevivedClass
{

	public static $classname = __CLASS__;
	private $revived = false;

	private function revived()
	{
		$this->revived = true;
	}

	public function isRevived()
	{
		return $this->revived;
	}

}

/**
 * @Revived
 */
class ProtectedRevivedClass
{

	public static $classname = __CLASS__;
	private $revived = false;

	protected function revived()
	{
		$this->revived = true;
	}

	public function isRevived()
	{
		return $this->revived;
	}

}

class NormalPropertyClass
{

	public static $classname = __CLASS__;
	/**
	 * @Summon
	 * @SummonType(NormalTestDependency::$classname)
	 * @var NormalTestDependency
	 */
	public $property;
}

class NormalOptionalPropertyClass
{

	public static $classname = __CLASS__;
	/**
	 * @Summon(true, true)
	 * @SummonType(iTestDependency::iTestDependency)
	 * @var iTestDependency
	 */
	public $property;
}

class ProtectedPropertyClass
{

	public static $classname = __CLASS__;
	/**
	 * @Summon
	 * @SummonType(NormalTestDependency::$classname)
	 * @var NormalTestDependency
	 */
	protected $property;

	public function getProperty()
	{
		return $this->property;
	}

}

class PrivatePropertyClass
{

	public static $classname = __CLASS__;
	/**
	 * @Summon
	 * @SummonType(NormalTestDependency::$classname)
	 * @var NormalTestDependency
	 */
	private $property;

	public function getProperty()
	{
		return $this->property;
	}

}

class PrivateMethodClass
{

	public static $classname = __CLASS__;
	private $summoned = false;

	/**
	 * @Summon
	 */
	private function methodSummon()
	{
		$this->summoned = true;
	}

	public function isSummoned()
	{
		return $this->summoned;
	}

}

class ProtectedMethodClass
{

	public static $classname = __CLASS__;
	private $summoned = false;

	/**
	 * @Summon
	 */
	protected function methodSummon()
	{
		$this->summoned = true;
	}

	public function isSummoned()
	{
		return $this->summoned;
	}

}

class MultipleTestClass implements iTest
{

	public static $classname = __CLASS__;

	public function getTestDependency()
	{
		
	}

}

class NormalMethodSummon
{

	public static $classname = __CLASS__;
	private $dependency;

	/**
	 * @Summon
	 */
	public function summon(NormalTestDependency $dependency)
	{
		$this->dependency = $dependency;
	}

	public function getDependency()
	{
		return $this->dependency;
	}

}

class EmptyMethodSummon
{

	public static $classname = __CLASS__;
	private $summoned = false;

	/**
	 * @Summon
	 */
	public function summon()
	{
		$this->summoned = true;
	}

	public function isSummoned()
	{
		return $this->summoned;
	}

}

class EmptyMethodNoSummon
{

	public static $classname = __CLASS__;
	private $summoned = false;

	/**
	 * @Summon(false)
	 */
	public function summon()
	{
		$this->summoned = true;
	}

	public function noSummon()
	{
		$this->summoned = true;
	}

	public function isSummoned()
	{
		return $this->summoned;
	}

}

interface iTest
{
	const iTest = __CLASS__;

	public function getTestDependency();
}

class TestClassWithoutITest
{

	public static $classname = __CLASS__;

}

interface iTestDependency
{
	const iTestDependency = __CLASS__;
}

class ScalarParamTestClass
{

	public static $classname = __CLASS__;

	public function __construct($testDependency)
	{
		
	}

}

class ArrayOptionalParamTestClass
{

	public static $classname = __CLASS__;

	public function __construct(array $testDependency = array())
	{
		
	}

}

class ClassNullableParamTestClass
{

	public static $classname = __CLASS__;
	private $testDependency;

	public function __construct(iTestDependency $testDependency = null)
	{
		$this->testDependency = $testDependency;
	}

	public function getTestDependency()
	{
		return $this->testDependency;
	}

}

class ArrayParamTestClass
{

	public static $classname = __CLASS__;

	public function __construct(array $testDependency)
	{
		
	}

}

class NormalTestClass implements iTest
{

	public static $classname = __CLASS__;
	private $testDependency;

	public function __construct(NormalTestDependency $testDependency)
	{
		$this->testDependency = $testDependency;
	}

	public function getTestDependency()
	{
		return $this->testDependency;
	}

}

class InterfaceTestClass implements iTest
{

	public static $classname = __CLASS__;
	private $testDependency;

	public function __construct(iTestDependency $testDependency)
	{
		$this->testDependency = $testDependency;
	}

	public function getTestDependency()
	{
		return $this->testDependency;
	}

}

class NormalTestDependency
{

	public static $classname = __CLASS__;

}

class InterfaceTestDependency implements iTestDependency
{

	public static $classname = __CLASS__;

}

// </editor-fold>
?>