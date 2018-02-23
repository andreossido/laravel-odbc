<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 20/02/2018
 * Time: 15:50
 */

namespace Abram\Odbc;

use Illuminate\Database\Connectors\Connector;
use Illuminate\Database\Connectors\ConnectorInterface;

class ODBCConnector extends Connector implements ConnectorInterface
{

    /**
     * Establish a database connection.
     *
     * @param array $config
     *
     * @return \PDO
     * @internal param array $options
     *
     */
    public function connect(array $config)
    {
        $options = $this->getOptions($config);

        $dsn = array_get($config, 'dsn');

        $connection = $this->createConnection($dsn, $config, $options);

        return $connection;
    }

    /**
     * Create a new PDO connection instance.
     *
     * @param  string $dsn
     * @param  string $username
     * @param  string $password
     * @param  array $options
     * @return ODBCPdo
     */
    protected function createPdoConnection($dsn, $username, $password, $options)
    {
        return new ODBCPdo($dsn, $username, $password);
    }
}