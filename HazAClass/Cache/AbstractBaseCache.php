<?php
/** * *******************************************************************************************************$
 * $Id:: AbstractBaseCache.php 103 2011-01-25 08:59:46Z manuelgrundner                                      $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 * ********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 * *****************************************Subversion Information********************************************
 * $LastChangedDate:: 2011-01-25 09:59:46 +0100 (Di, 25 Jän 2011)                                          $
 * $LastChangedRevision:: 103                                                                               $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/AbstractBaseCache.php  $
 * ********************************************************************************************************* */

namespace HazAClass\Cache;

use HazAClass\System\TimeSpan;

abstract class AbstractBaseCache implements ICacheProvider
{

	public static $classname = __CLASS__;
	private $defaultExpireTime;
	private $enabled = true;

	public function __construct(ICacheConfig $config)
	{
		$this->enabled = $config->IsEnabled();
		$this->defaultExpireTime = $config->GetDefaultExpireTime();
	}

	public function Invalidated($name)
	{
		$time = $this->getTimeFromStorage($name);

		if($time == TimeSpan::NEVER)
			return false;

		return $time === null ? true : $time < time();
	}

	abstract protected function GetTimeFromStorage($name);

	public function Invalidate()
	{
		throw new CacheInvalidatedException('Cache is invalidated');
	}

	protected function CheckInvalidation()
	{
		$this->CheckCacheIsEnabled();
		if($this->Invalidated($name))
			$this->Invalidate($name);
	}

	public function GetValue($name)
	{
		$this->CheckInvalidation($name);

		$value = $this->getValueFromStorage($name); 
		return unserialize($value);
	}

	abstract protected function getValueFromStorage($name);

	public function store($name, $value, $expireTime = null)
	{
		if($this->IsEnabled())
		{
			$value = serialize($value);

			if($expireTime === null)
				$expireTime = $this->getDefaultExpireTime();

			if($expireTime !== iCacheProvider::NEVER)
				$expireTime = time() + $expireTime;

			$this->storeToStorage($name, $value, $expireTime);
			Debug::log('Storing '.$name.'('.$expireTime.') to Cache ('.static::$classname.')');
		}
	}

	abstract protected function storeToStorage($name, $value, $expireTime);

	public function getDefaultExpireTime()
	{
		return $this->defaultExpireTime;
	}

	protected function setDefaultExpireTime($defaultExpireTime)
	{
		$this->defaultExpireTime = $defaultExpireTime;
	}

	public function disable()
	{
		$this->enabled = false;
	}

	public function enable()
	{
		$this->enabled = true;
	}

	public function IsEnabled()
	{
		return $this->enabled;
	}

	protected function CheckCacheIsEnabled()
	{
		if($this->IsEnabled())
			return;

		throw new CacheInvalidatedException('Cache is disabled');
	}

}

?>
