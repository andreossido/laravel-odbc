<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 23/02/2018
 * Time: 17:51
 */

namespace Abram\Odbc;

use PDOStatement;

class ODBCPdoStatement extends PDOStatement
{
    protected $query;
    protected $params = [];
    protected $statement;

    public function __construct($conn, $query)
    {
        $this->query = preg_replace('/(?<=\s|^):[^\s:]++/um', '?', $query);

        $this->params = $this->getParamsFromQuery($query);

        $this->statement = odbc_prepare($conn, $this->query);
    }

    protected function getParamsFromQuery($qry)
    {
        $params = [];
        $qryArray = explode(" ", $qry);
        $i = 0;

        while (isset($qryArray[$i])) {
            if (preg_match("/^:/", $qryArray[$i]))
            {
                $namedParam = substr($qryArray[$i], 1); // omite el : del nombre (MK)
                $params[$namedParam] = null;
            }

            $i++;
        }

        return $params;
    }

    public function rowCount()
    {
        return odbc_num_rows($this->statement);
    }

    public function bindValue($param, $val, $ignore = null)
    {
        $this->params[$param] = $val;
    }

    public function execute($ignore = null)
    {
        odbc_execute($this->statement, $this->params);
        $this->params = [];
    }

    public function fetchAll($how = NULL, $class_name = NULL, $ctor_args = NULL)
    {
        $records = [];
        $stored_proc = false;

        if (strlen($this->query) > 17)
        {
            if (strtolower(substr($this->query, 0, 17)) == 'execute procedure')
            {
                // MK: if it's a stored procedure, column names may not be included
                $stored_proc = true;
            }
        }

        if (! $stored_proc)
        {
            while ($record = $this->fetch()) {
                $records[] = $record;
            }
        }
        else
        {
            $records[] = $this->fetch_into($records);
        }

        return $records;
    }

    public function fetch($option = null, $ignore = null, $ignore2 = null)
    {
        return odbc_fetch_array($this->statement);
    }

    public function fetch_into($records)
    {
    // (MK) official doc https://www.redbooks.ibm.com/redbooks/pdfs/sg247218.pdf page 186
        odbc_fetch_into($this->statement, $records);
        return $records;
    }
}
