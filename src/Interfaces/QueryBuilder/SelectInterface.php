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

namespace Apatis\SimpleDB\Interfaces\QueryBuilder;

use Apatis\SimpleDB\Interfaces\ConnectionInterface;

/**
 * Interface SelectInterface
 * @package Apatis\SimpleDB\Interfaces\QueryBuilder
 */
interface SelectInterface extends ConditionalQueryInterface
{
    /**
     * SelectInterface constructor.
     *
     * @param ConnectionInterface $connection
     * @param string $table
     * @param array $columnExpression
     */
    public function __construct(ConnectionInterface $connection, string $table, array $columnExpression = ['*']);

    /**
     * SelectAbstract from
     *
     * @param string $table
     * @param string|null $alias
     *
     * @return static|SelectInterface
     */
    public function from(string $table, string $alias = null) : SelectInterface;

    /**
     * @return string|null
     */
    public function getTable();

    /**
     * @return string|null
     */
    public function getTableAlias();

    /**
     * Set Sort ORDER, call without arguments to reset sort
     * RANDOM, ASC, DESC
     *
     * @param string $column
     *
     * @return static|SelectInterface
     */
    public function orderBy(string $column = null) : SelectInterface;

    /**
     * @return string|null
     */
    public function getOrderBy();

    /**
     * Set Sort by column name
     *
     * @param string $sort
     *
     * @return static|SelectInterface
     */
    public function sort(string $sort = null) : SelectInterface;

    /**
     * @return string|null
     */
    public function getSort();

    /**
     * Offset to get, call without arguments to reset offset
     *
     * @param int $offset
     *
     * @return static|SelectInterface
     */
    public function offset(int $offset = null) : SelectInterface;

    /**
     * @return string|null
     */
    public function getOffset();

    /**
     * Set Limit, call without arguments to reset limit
     *
     * @param int $limit
     *
     * @return static|SelectInterface
     */
    public function limit(int $limit = null) : SelectInterface;

    /**
     * @return int|null
     */
    public function getLimit();

    public function join() : SelectInterface;
    public function getJoin();

    public function union() : SelectInterface;
    public function getUnion();

    public function groupBy(string $column = null) : SelectInterface;
    public function getGroupBy();

    public function having($statements = null, $value = null) : SelectInterface;
    public function getHaving();

    /**
     * @return null|string
     */
    public function getHavingQuery();

    /**
     * Set As count cloned object
     *
     * @param string $alias
     *
     * @return static|SelectInterface
     */
    public function asCount(string $alias = 'c') : SelectInterface;

    /**
     * Convert To UpdateAbstract
     *
     * @return UpdateInterface
     */
    public function toUpdate() : UpdateInterface;

    /**
     * Convert to DeleteAbstract
     *
     * @return DeleteInterface
     */
    public function toDelete() : DeleteInterface;
}
