<?php
/**
 * MIT License
 *
 * Copyright (c) 2017 Pentagonal Development
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

namespace Apatis\SimpleDB\Abstracts\QueryBuilder;

use Apatis\SimpleDB\Abstracts\ConditionalQueryAbstract;
use Apatis\SimpleDB\Interfaces\ConnectionInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\SelectInterface;

/**
 * Class SelectAbstract
 * @package Apatis\SimpleDB\Abstracts\QueryBuilder
 */
abstract class SelectAbstract extends ConditionalQueryAbstract implements SelectInterface
{
    /**
     * @var array
     */
    protected $selectedColumns;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string|null
     */
    protected $tableAlias;

    /**
     * @var string|null
     */
    protected $sort;

    /**
     * @var string|null
     */
    protected $orderBy;

    /**
     * @var int|null
     */
    protected $offset;

    /**
     * @var int|null
     */
    protected $limit;

    /**
     * @var string|null string statement group
     */
    protected $groupBy;

    /**
     * @var array|array[]|null|mixed
     */
    protected $join;

    /**
     * @var array|array[]|null|mixed
     */
    protected $union;

    /**
     * @var string|null|mixed
     */
    protected $having;

    /**
     * {@inheritdoc}
     */
    public function __construct(ConnectionInterface $connection, string $table, array $columnExpression = ['*'])
    {
        $this->connection = $connection;
        $this->table = $table;
        if (empty($columnExpression)) {
            $this->selectedColumns = ['*'];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function from(string $table, string $alias = null) : SelectInterface
    {
        $this->table = $table;
        $this->tableAlias = $alias;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * {@inheritdoc}
     */
    public function getTableAlias()
    {
        return $this->tableAlias;
    }

    /**
     * {@inheritdoc}
     */
    public function orderBy(string $column = null): SelectInterface
    {
        $this->orderBy = $column;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOrderBy()
    {
        return $this->orderBy;
    }

    /**
     * {@inheritdoc}
     */
    public function sort(string $sort = null) : SelectInterface
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * {@inheritdoc}
     */
    public function offset(int $offset = null) : SelectInterface
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOffset()
    {
        return $this->offset;
    }

    /**
     * {@inheritdoc}
     */
    public function limit(int $limit = null) : SelectInterface
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * {@inheritdoc}
     */
    public function join() : SelectInterface
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getJoin()
    {
        return $this->join;
    }

    /**
     * {@inheritdoc}
     */
    public function union() : SelectInterface
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUnion()
    {
        return $this->union;
    }

    /**
     * {@inheritdoc}
     */
    public function groupBy(string $column = null) : SelectInterface
    {
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupBy()
    {
        return $this->groupBy;
    }

    /**
     * {@inheritdoc}
     */
    public function having($statements = null, $value = null) : SelectInterface
    {
        if (func_num_args() === 0) {
            $this->having = null;
            return $this;
        }

        $this->having = [
            'statement' => $statements
        ];

        if (func_num_args() > 1) {
            $this->having['value'] = $value;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getHaving()
    {
        return $this->having;
    }
}
