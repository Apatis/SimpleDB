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

namespace Apatis\SimpleDB\Driver\MySQL;

use Apatis\SimpleDB\Driver\MySQL\QueryBuilder\Delete;
use Apatis\SimpleDB\Driver\MySQL\QueryBuilder\Select;
use Apatis\SimpleDB\Driver\MySQL\QueryBuilder\Update;
use Apatis\SimpleDB\Interfaces\ConnectionInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\BaseQueryInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\DeleteInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\QueryBuilderInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\SelectInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\UpdateInterface;

/**
 * Class QueryBuilder
 * @package Apatis\SimpleDB\Driver\MySQL
 */
class QueryBuilder implements QueryBuilderInterface
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * QueryBuilder constructor.
     *
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection =& $connection;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection() : ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @param string $class
     * @param array $args
     *
     * @return object|BaseQueryInterface|mixed
     */
    protected function instanceCreateObject(string $class, array $args) : BaseQueryInterface
    {
        array_unshift($args, $this->getConnection());
        $ref = new \ReflectionClass($class);
        $object = $ref->newInstanceArgs($args);
        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function select(array $select = ['*'], $expression = null) : SelectInterface
    {
        return $this->instanceCreateObject(Select::class, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function update(string $table) : UpdateInterface
    {
        return $this->instanceCreateObject(Update::class, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function delete(string $table) : DeleteInterface
    {
        return $this->instanceCreateObject(Delete::class, func_get_args());
    }
}
