<?php
/**
 * Created by PhpStorm.
 * User: Andrea
 * Date: 21/03/2018
 * Time: 16:30
 */

namespace Abram\Odbc;

use App\BaseModel;
use Illuminate\Database\Query\Builder;

class ODBCBuilder extends Builder
{
    /**
     * @var BaseModel
     */
    private $model;

    public function __construct($connection,
                                $grammar = null,
                                $processor = null,
                                $model = null)
    {
        $this->model = $model;
        return parent::__construct($connection, $grammar, $processor);
    }

    public function whereIn($column, $values, $boolean = 'and', $not = false)
    {
        return parent::whereIn($column, $values, $boolean, $not);
    }


    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        list($value, $operator) = $this->prepareValueAndOperator(
            $value, $operator, func_num_args() == 2
        );
        $value = $this->getModel()->wrapAttribute($column, $value);
        return parent::where($column, $operator, $value, $boolean);
    }

    /**
     * @return BaseModel
     */
    public function getModel(): BaseModel
    {
        return $this->model;
    }

    /**
     * @param BaseModel $model
     */
    public function setModel(BaseModel $model): void
    {
        $this->model = $model;
    }
}