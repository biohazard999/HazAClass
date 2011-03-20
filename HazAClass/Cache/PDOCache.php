<?php
/** ********************************************************************************************************$
 * $Id:: PDOCache.php 4 2010-11-06 12:37:02Z manuelgrundner                                                 $
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
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/PDOCache.php           $
 ***********************************************************************************************************/

namespace HazAClass\core\cache;

use HazAClass\core\config\system\cache\SQLiteCacheConfig;
use SQLite3;
use SQLite3Stmt;
use HazAClass\core\debug\Debug;
use HazAClass\utils\StringUtil;

/**
 *
 */
class SQLiteCache implements iCacheProvider
{
	public static $classname = __CLASS__;

	private $config;
	private $connection;

	function __construct(SQLiteCacheConfig $config)
	{
        $this->config = $config;
		$this->connection = new PDO($this->config->path);
		
		$this->createTable();
    }

	private function createTable()
	{
		$this->connection->exec(
				sprintf('CREATE TABLE IF NOT EXISTS %s (
							name VARCHAR(41) PRIMARY KEY,
							value TEXT,
							expireTime INTEGER)',
						$this->config->tablename));

		$this->connection->exec(
				sprintf('CREATE INDEX IF NOT EXISTS
							SQLiteCache_expireTime
						 ON
							%s (expireTime)',
						$this->config->tablename));
	}
	
    public function equals($name, $value)
    {
		return $this->getValue($name) === $value;
    }

    public function flush($name)
    {
        $this->connection->exec(
				sprintf('DELETE FROM %s WHERE name=\'%s\'',
						$this->config->tablename,
						$name));
    }

    public function flushAll()
    {
		$this->connection->exec(
				sprintf('DROP TABLE IF EXISTS %s',
						$this->config->tablename));
		$this->createTable();
    }

    public function getValue($name)
    {
		$value = $this->connection->querySingle(
					sprintf('SELECT value FROM %s WHERE name=\'%s\'',
							$this->config->tablename,
							$name));

		//Dirty work around for decoding a UTF8 generated PHP-Files
		$value = StringUtil::replace($value, "~~NULL_BYTE~~", "\0");
		
       	return unserialize($value);
    }

    public function isOutdated($name)
    {
		$time = $this->connection->querySingle(
					sprintf('SELECT expireTime FROM %s WHERE name=\'%s\'',
							$this->config->tablename,
							$name));
		
        return $time === null ? true : $time < time();
    }

	public function escape($value) {
       	if(is_numeric($value))
			return $value;
		else
		{
			//Dirty work around for encoding a UTF8 generated PHP-Files
			$value = StringUtil::replace($value, "\0", "~~NULL_BYTE~~");
           	return $this->connection->escapeString($value);
		}
	}

    public function stored($name)
    {
		$name = $this->connection->querySingle(
				sprintf('SELECT name FROM %s WHERE name=\'%s\'',
						$this->config->tablename,
						$name));
		
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

	private function bindParams(SQLite3Stmt $stmt, $value, $expireTime, $name)
	{
		$stmt->bindParam(':value', $value);
		$stmt->bindParam(':expireTime', $expireTime);
		$stmt->bindParam(':name', $name);
		return $stmt;
	}

	/**
	 * @return \SQLite3Stmt
	 */
	private function getUpdateStatement()
	{
		return $this->connection->prepare(
						sprintf('UPDATE %s SET value=:value, expireTime=:expireTime WHERE name=:name',
								$this->config->tablename));
	}

	/**
	 * @return \SQLite3Stmt
	 */
	private function getInsertStatement()
	{
		return $this->connection->prepare(
						sprintf('INSERT INTO %s (name, value, expireTime) VALUES (:name, :value, :expireTime)',
								$this->config->tablename));
	}

    public function cleanUp()
    {
		$this->connection->exec(
				sprintf('DELETE FROM %s WHERE expireTime<%d',
						$this->config->tablename,
						time()));
    }

}

?>
