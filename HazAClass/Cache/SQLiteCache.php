<?php

/** ********************************************************************************************************$
 * $Id:: SQLiteCache.php 30 2010-11-14 17:41:29Z manuelgrundner                                             $
 * @author Manuel Grundner <biohazard999@gmx.at>,  Ren� Grundner <hazard999@gmx.de>                         $
 * @copyright Copyright (c) 2009, Manuel Grundner & Ren� Grundner                                           $
 *                                                                                                          $
 *********************************************Documentation**************************************************
 *                                                                                                          $
 * @package                                                                                                 $
 * @subpackage                                                                                              $
 *                                                                                                          $
 ******************************************Subversion Information********************************************
 * $LastChangedDate:: 2010-11-14 18:41:29 +0100 (So, 14 Nov 2010)                                           $
 * $LastChangedRevision:: 30                                                                                $
 * $LastChangedBy:: manuelgrundner                                                                          $
 * $HeadURL:: http://x2.delegate.at/svn/HazAClass_Sandbox/trunk/HazAClass/core/cache/SQLiteCache.php        $
 ********************************************************************************************************** */

namespace HazAClass\core\cache;

use HazAClass\core\config\system\cache\SQLiteCacheConfig;
use SQLite3;
use SQLite3Stmt;
use HazAClass\core\debug\Debug;
use HazAClass\utils\StringUtil;

/**
 *
 */
class SQLiteCache extends AbstractBaseCache
{

    public static $classname = __CLASS__;
    private $config;
    private $connection;

    public function __construct(SQLiteCacheConfig $config)
    {
		parent::__construct($config);
        $this->config = $config;
        $this->connection = new SQLite3($this->config->path);

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

    protected function getValueFromStorage($name)
    {
        $value = $this->connection->querySingle(
                        sprintf('SELECT value FROM %s WHERE name=\'%s\'',
                                $this->config->tablename,
                                $name));

        return DatabaseCacheHelper::decodeNullCharacter($value);
    }

    protected function getTimeFromStorage($name)
    {
        $time = $this->connection->querySingle(
                        sprintf('SELECT expireTime FROM %s WHERE name=\'%s\'',
                                $this->config->tablename,
                                $name));
        if($time === null)
            $this->invalidate($name);

        return $time;
    }

    protected function escape($value)
    {
        if(is_numeric($value))
            return $value;
        else
        {
            $value = DatabaseCacheHelper::encodeNullCharacter($value);
            return $this->connection->escapeString($value);
        }
    }

    protected function storeToStorage($name, $value, $expireTime)
    {
		$value = $this->escape($value);
        $stmt = $this->isStored($name) ? $this->getUpdateStatement() : $this->getInsertStatement();
        $this->bindParams($stmt, $value, $expireTime, $name);

        $stmt->execute();
    }

	private function isStored($name)
	{
		$name = $this->connection->querySingle(
                        sprintf('SELECT name FROM %s WHERE name=\'%s\'',
                                $this->config->tablename,
                                $name));
		return $name !== null;
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
