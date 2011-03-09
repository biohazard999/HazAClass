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

namespace HazAClass\System\Collection;

abstract class AbstractListTest extends \PHPUnit_Framework_TestCase
{

	public static $classname = __CLASS__;
	/**
	 * @var ArrayList
	 */
	protected $list;

	/**
	 * @return ArrayList
	 */
	public function getList()
	{
		return $this->list;
	}

	public abstract function ElementDataProvider();
	
	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testCount($indexA, $indexB, $a, $b)
	{
		$this->assertEquals(0, $this->list->count());
		$this->assertEquals(0, count($this->list));

		$this->getList()->AddElement($a);
		$this->getList()->AddElement($b);

		$this->assertEquals(2, $this->list->count());
		$this->assertEquals(2, count($this->list));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testOffsetExists($indexA, $indexB, $a, $b)
	{
		$this->assertFalse($this->getList()->offsetExists($indexA));
		$this->assertFalse($this->getList()->offsetExists($indexB));

		$this->getList()->InsertElement($indexA, $a);
		$this->getList()->InsertElement($indexB, $b);

		$this->assertTrue($this->getList()->offsetExists($indexA));
		$this->assertTrue($this->getList()->offsetExists($indexB));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testOffsetGet($indexA, $indexB, $a, $b)
	{
		$this->getList()->InsertElement($indexA, $a);
		$this->getList()->InsertElement($indexB, $b);

		$this->assertEquals($a, $this->list[$indexA]);
		$this->assertEquals($b, $this->list[$indexB]);

		$this->assertEquals($a, $this->getList()->offsetGet($indexA));
		$this->assertEquals($b, $this->getList()->offsetGet($indexB));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testOffsetSet($indexA, $indexB, $a, $b)
	{
		$this->getList()->InsertElement($indexA, $a);
		$this->getList()->InsertElement($indexB, $b);

		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		$this->assertEquals($a, $this->getList()->offsetGet($indexA));
		$this->assertEquals($b, $this->getList()->offsetGet($indexB));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testOffsetUnset($indexA, $indexB, $a, $b)
	{
		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		unset($this->list[$indexA]);
		unset($this->list[$indexB]);

		$this->assertFalse(isset($this->list[$indexA]));
		$this->assertFalse(isset($this->list[$indexB]));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testCurrent($indexA, $indexB, $a, $b)
	{
		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		$this->assertEquals($a, $this->getList()->current());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testKey($indexA, $indexB, $a, $b)
	{
		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		$this->assertEquals($indexA, $this->getList()->key());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testNext($indexA, $indexB, $a, $b)
	{
		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		$this->assertEquals($b, $this->getList()->next());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testRewind($indexA, $indexB, $a, $b)
	{
		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		$this->getList()->next();

		$this->assertEquals($a, $this->getList()->rewind());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testValid($indexA, $indexB, $a, $b)
	{
		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		$this->assertTrue($this->getList()->valid());
		$this->getList()->next();
		$this->assertTrue($this->getList()->valid());
		$this->getList()->next();
		$this->assertFalse($this->getList()->valid());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testToArray($indexA, $indexB, $a, $b)
	{
		$this->list[$indexA] = $a;
		$this->list[$indexB] = $b;

		$this->assertEquals(array($indexA => $a, $indexB => $b), $this->list->ToArray());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testAddArray($indexA, $indexB, $a, $b)
	{
		$this->getList()->AddArray(array($indexA => $a, $indexB => $b));

		$this->assertEquals(array(0 => $a, 1 => $b), $this->list->ToArray());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testAddElement($indexA, $indexB, $a, $b)
	{
		$this->getList()->AddElement($a);
		$this->getList()->AddElement($b);

		$this->assertEquals(array(0 => $a, 1 => $b), $this->list->ToArray());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testAddIterator($indexA, $indexB, $a, $b)
	{
		$list = new ArrayList();
		$list->AddElement($a);
		$list->AddElement($b);

		$this->getList()->AddIterator($list);

		$this->assertEquals(array(0 => $a, 1 => $b), $this->list->ToArray());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testAddRange($indexA, $indexB, $a, $b)
	{
		$list = new ArrayList();
		$list->AddElement($a);
		$list->AddElement($b);

		$this->getList()->AddRange($list);

		$this->getList()->AddRange(array($a, $b));

		$this->assertEquals(array(0 => $a, 1 => $b, 2 => $a, 3 => $b), $this->list->ToArray());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testFlushElements($indexA, $indexB, $a, $b)
	{
		$list = new ArrayList();
		$list->AddElement($a);
		$list->AddElement($b);

		$this->getList()->AddRange($list);

		$this->getList()->AddRange(array($a, $b));

		$this->assertEquals(array(0 => $a, 1 => $b, 2 => $a, 3 => $b), $this->list->ToArray());

		$this->assertEquals(4, $this->getList()->count());
		$this->getList()->FlushElements();
		$this->assertEquals(0, $this->getList()->count());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testGetFirstElement($indexA, $indexB, $a, $b)
	{
		$list = new ArrayList();
		$list->AddElement($a);
		$list->AddElement($b);

		$this->getList()->AddRange($list);

		$this->assertEquals($a, $this->getList()->GetFirstElement());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testGetLastElement($indexA, $indexB, $a, $b)
	{
		$list = new ArrayList();
		$list->AddElement($a);
		$list->AddElement($b);

		$this->getList()->AddRange($list);

		$this->assertEquals($b, $this->getList()->GetLastElement());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testGetKeys($indexA, $indexB, $a, $b)
	{
		$list = new ArrayList();
		$list->AddElement($a);
		$list->AddElement($b);

		$this->getList()->AddRange($list);

		$this->assertEquals(array(0, 1), $this->getList()->GetKeys()->ToArray());
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testIndexOf($indexA, $indexB, $a, $b)
	{
		$list = new ArrayList();
		$list->AddElement($a);
		$list->AddElement($b);

		$this->getList()->AddRange($list);

		$this->assertEquals(1, $this->getList()->IndexOf($b));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testInsertElement($indexA, $indexB, $a, $b)
	{

		$this->getList()->InsertElement(1, $a);
		$this->getList()->InsertElement(2, $b);

		$this->assertEquals(2, $this->getList()->IndexOf($b));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testRemove($indexA, $indexB, $a, $b)
	{
		$this->getList()->InsertElement(1, $b);
		$this->getList()->Remove($b);

		$this->assertEquals(null, $this->getList()->IndexOf($b));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testRemoveAt($indexA, $indexB, $a, $b)
	{
		$this->getList()->InsertElement($indexA, $b);
		$this->getList()->RemoveAt($indexA);

		$this->assertEquals(null, $this->getList()->IndexOf($b));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testIndexExists($indexA, $indexB, $a, $b)
	{
		$this->getList()->InsertElement(1, $b);

		$this->assertTrue($this->getList()->IndexExists(1));
		$this->assertFalse($this->getList()->IndexExists(0));
	}

	/**
	 * @dataProvider ElementDataProvider
	 */
	public function testElementExists($indexA, $indexB, $a, $b)
	{
		$this->getList()->InsertElement(1, $b);

		$this->assertTrue($this->getList()->ElementExists($b));
		$this->assertFalse($this->getList()->ElementExists($a));
	}


	public function testAddRangeException()
	{
		$this->setExpectedException('\\InvalidArgumentException');
		$this->getList()->AddRange('abc');
	}

}

?>