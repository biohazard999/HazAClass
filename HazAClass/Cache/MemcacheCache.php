<?php

/** * *******************************************************************************************************$
 * $Id:: MemcacheCache.php 61 2010-12-15 09:26:12Z manuelgrundner                                           $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-12-15 10:26:12 +0100 (Mi, 15 Dez 2010)                                           $
 * $LastChangedRevision:: 61                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/MemcacheCache.php      $
 * ********************************************************************************************************* */

namespace HazAClass\core\cache;

use HazAClass\core\config\system\cache\MemcacheCacheConfig;

class MemcacheCache extends AbstractBaseCache
{

	public static $classname = __CLASS__;
	/**
	 * @var Memcache
	 */
	private $memcache;
	/**
	 * @var MemcacheCacheConfig
	 */
	private $config;

	public function __construct(MemcacheCacheConfig $config)
	{
		parent::__construct($config);

		$this->config = $config;
		$this->memcache = new \Memcache();

		$success = false;
		if($config->perstistConnection)
			$success = $this->memcache->pconnect($config->host, $config->port, $config->timeout);
		else
			$success = $this->memcache->connect($config->host, $config->port, $config->timeout);

		if(!$success)
			throw new MemcacheConnectionException(
					sprintf('Could not connect to memcache. Host: %s Port: %d Timeout: %d Persistent: %d',
							$config->host,
							$config->port,
							$config->timeout,
							$config->perstistConnection));
	}

	protected function getTimeFromStorage($name)
	{
		return time() + 1; //Could not get time from storage, so its never outdated. getValueFromStorage does the trick
	}

	protected function getValueFromStorage($name)
	{
		$retVal = $this->memcache->get($name);

		if($retVal === false)
			$this->invalidated($name);

		return $retVal;
	}

	protected function storeToStorage($name, $value, $expireTime)
	{
		if($expireTime === iCacheProvider::NEVER)
			$expireTime = 0;
		
		$this->memcache->set($name, $value, 0, $expireTime);
	}

	public function cleanUp()
	{
		$this->memcache->flush();
	}

}

?>
