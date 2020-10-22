<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 23/02/2018
 * Time: 17:50
 */

namespace Abram\Odbc;

use Exception;
use PDO;

class ODBCPdo extends PDO
{
    protected $connection;

    public function __construct($dsn, $username, $passwd, $options = [])
    {
        $this->setConnection(odbc_connect($dsn, $username, $passwd));
    }

    public function exec($query)
    {
        return $this->prepare($query)->execute();
    }

    public function prepare($statement, $driver_options = null)
    {
        return new ODBCPdoStatement($this->getConnection(), $statement);
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection): void
    {
        $this->connection = $connection;
    }

    /**
     * @param null $name
     * @return string|void
     * @throws Exception
     */
    public function lastInsertId($name = null)
    {
        throw new Exception("Error, you must override this method!");
    }

    public function commit()
    {
        // informix: primero habilitar logging con: ontape -s -B b2b
        $commit = odbc_commit($this->getConnection());
        odbc_autocommit($this->getConnection(), true);
        return $commit;
    }

    public function rollBack()
    {
        $rollback = odbc_rollback($this->getConnection());
        odbc_autocommit($this->getConnection(), true);
        return $rollback;
    }

    public function beginTransaction()
    {
        odbc_autocommit($this->getConnection(), false);
    }
}
