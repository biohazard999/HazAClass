<?php
/** ********************************************************************************************************$
 * $Id:: MySQLCache.php 4 2010-11-06 12:37:02Z manuelgrundner                                               $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 *********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 ******************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-06 13:37:02 +0100 (Sa, 06 Nov 2010)                                           $
 * $LastChangedRevision:: 4                                                                                 $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/MySQLCache.php         $
 ***********************************************************************************************************/

namespace HazAClass\core\cache;

use HazAClass\core\config\system\cache\MySQLCacheConfig;
use mysqli;
use mysqli_stmt;
use HazAClass\core\debug\Debug;
use HazAClass\utils\StringUtil;

/**
 *
 */
class MySQLCache extends AbstractBaseCache
{
	public static $classname = __CLASS__;

	/**
	 * @var MySQLCacheConfig
	 */
	private $config;
	private $connection;

	function __construct(MySQLCacheConfig $config)
	{
        $this->config = $config;
		$this->connection = new mysqli($this->config->host,
									   $this->config->username,
									   $this->config->password,
									   $this->config->database,
									   $this->config->port);
		
		$this->createTable();
    }

	private function createTable()
	{
		$this->connection->query(
				sprintf('CREATE TABLE IF NOT EXISTS %s (
							cache_name VARCHAR( 41 ) NOT NULL ,
							cache_value TEXT,
							cache_expireTime INT( 11 ) UNSIGNED NOT NULL ,
							PRIMARY KEY (name),
							INDEX (expireTime)',
						$this->config->tablename));
	}
	
    public function equals($name, $value)
    {
		return $this->getValue($name) === $value;
    }

    public function flush($name)
    {
        $this->connection->query(
				sprintf('DELETE FROM %s WHERE cache_name=\'%s\'',
						$this->config->tablename,
						$name));
    }

    public function flushAll()
    {
		$this->connection->query(
				sprintf('DROP TABLE IF EXISTS %s',
						$this->config->tablename));
		$this->createTable();
    }

    public function getValue($name)
    {
		$value = $this->connection->query(
					sprintf('SELECT cache_value FROM %s WHERE cache_name=\'%s\'',
							$this->config->tablename,
							$name));

		$value = DatabaseCacheHelper::decodeNullCharacter($value);

      	return unserialize($value);
    }

    public function isOutdated($name)
    {
		$time = $this->connection->query(
					sprintf('SELECT cache_expireTime FROM %s WHERE cache_name=\'%s\'',
							$this->config->tablename,
							$name));
		
        return $time === null ? true : $time < time();
    }

	public function escape($value) {
       	if(is_numeric($value))
			return $value;
		else
		{
			$value = $value = DatabaseCacheHelper::encodeNullCharacter($value);
           	return $this->connection->escape_string($value);
		}
	}

    public function stored($name)
    {
		$name = $this->connection->query(
				sprintf('SELECT cache_name FROM %s WHERE cache_name=\'%s\'',
						$this->config->tablename,
						$name));
		Debug::error($name);
		return $name !== null;
    }

    public function store($name, $value, $expireTime = null)
    {
		$value = $this->escape(serialize($value));

       	if($expireTime === null)
			$expireTime = $this->config->defaultExpireTime;

		$expireTime = time() + $expireTime;
		
		$stmt = $this->stored($name) ? $this->getUpdateStatement() : $this->getInsertStatement();
      	$this->bindParams($stmt, $value, $expireTime, $name);

      	$stmt->execute();
    }

	private function bindParams(mysqli_stmt $stmt, $value, $expireTime, $name)
	{
		$stmt->bind_param('sis', $value, $expireTime, $name);
		return $stmt;
	}

	/**
	 * @return \mysqli_stmt
	 */
	private function getUpdateStatement()
	{
		return $this->connection->prepare(
						sprintf('UPDATE %s SET cache_value=?, cache_expireTime=? WHERE cache_name=?',
								$this->config->tablename));
	}

	/**
	 * @return \mysqli_stmt
	 */
	private function getInsertStatement()
	{
		return $this->connection->prepare(
						sprintf('INSERT INTO %s (cache_name, cache_value, cache_expireTime) VALUES (?, ?, ?)',
								$this->config->tablename));
	}

    public function cleanUp()
    {
		$this->connection->query(
				sprintf('DELETE FROM %s WHERE cache_expireTime<%d',
						$this->config->tablename,
						time()));
    }

	protected function getTimeFromStorage($name)
	{

	}

	protected function getValueFromStorage($name)
	{

	}

	protected function storeToStorage($name, $value, $expireTime)
	{

	}

}

?>
