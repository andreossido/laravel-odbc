<?php

namespace Abram\Odbc;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\Processors\Processor;

class ODBCProcessor extends Processor
{
    /**
     * Process an "insert get ID" query.
     *
     * @param Builder $query
     * @param  string $sql
     * @param  array $values
     * @param  string $sequence
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
        $query->getConnection()->insert($sql, $values);

        $id = $this->getLastInsertId($query, $sequence);

        return is_numeric($id) ? (int)$id : $id;
    }

    /**
     * @param Builder $query
     * @param null $sequence
     * @return mixed
     */
    public function getLastInsertId(Builder $query, $sequence = null){
        return $query->getConnection()->getPdo()->lastInsertId();
    }
}
