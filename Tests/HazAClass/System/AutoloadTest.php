<?php

namespace HazAClass\System;

require_once dirname(__FILE__).'/../../../HazAClass/System/Autoload.php';

/**
 * Test class for Autoload.
 * Generated by PHPUnit on 2011-03-09 at 11:12:16.
 */
class AutoloadTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Autoload
	 */
	protected $autoload;

	const MAINNAMESPACE = 'CustomNameSpace';
	const AUTOLOAD_EXT = 'class.php';

	protected function setUp()
	{
		$this->autoload = new Autoload(self::MAINNAMESPACE, __DIR__.DIRECTORY_SEPARATOR.'CustomNameSpace', self::AUTOLOAD_EXT);
	}

	protected function tearDown()
	{
		Autoload::UnRegisterAutoloader($this->autoload);
		$this->autoload = null;
	}

	public function testGetMainNameSpace()
	{
		$this->assertEquals(self::MAINNAMESPACE.'\\', $this->autoload->GetMainNameSpace());
	}

	public function testGetExtension()
	{
		$this->assertEquals(self::AUTOLOAD_EXT, $this->autoload->GetExtension());
	}

	public function testLoad()
	{
		$classname = '\\'.self::MAINNAMESPACE.'\\AutoloadTestClass';
		$this->assertFalse(class_exists($classname, false));
		$this->autoload->load($classname);
		$this->assertTrue(class_exists(\CustomNameSpace\AutoloadTestClass::$classname), false);
	}

	public function testRegisterAutoloader()
	{
		$classname = '\\'.self::MAINNAMESPACE.'\\NeverloadedClass';
		Autoload::UnRegisterAutoloader($this->autoload);

		$this->assertFalse(class_exists($classname, true));

		Autoload::RegisterAutoloader($this->autoload);

		$this->assertTrue(class_exists($classname, true));
	}

	public function testGetFrameworkPath()
	{
		$this->assertEquals(__DIR__.DIRECTORY_SEPARATOR.'CustomNameSpace'.DIRECTORY_SEPARATOR, $this->autoload->GetFrameworkPath());
	}

	public function testLoadDir()
	{
		$this->assertFalse(class_exists('\\CustomDir\\CustomClass1', false));
		$this->assertFalse(class_exists('\\CustomDir\\CustomClass2', false));
		$result = Autoload::LoadDir(__DIR__.DIRECTORY_SEPARATOR.'CustomDir', 'CustomDir');
		$this->assertTrue(class_exists('\\CustomDir\\CustomClass1', false));
		$this->assertTrue(class_exists('\\CustomDir\\CustomClass2', false));

		$this->assertEquals(2, $result->count());
	}

}

?>
