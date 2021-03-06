<?php

namespace HazAClass\System\Xml;

require_once dirname(__FILE__).'/../../../../HazAClass/System/Xml/XmlElement.php';

/**
 * Test class for XmlElement.
 * Generated by PHPUnit on 2011-03-21 at 18:43:44.
 */
class XmlElementTest extends XmlNodeTest
{
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new XmlElement('html');
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 */
	protected function tearDown()
	{
		$this->object = null;
	}

}

?>
