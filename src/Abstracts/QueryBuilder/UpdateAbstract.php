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
use Apatis\SimpleDB\Interfaces\QueryBuilder\DeleteInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\SelectInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\UpdateInterface;

/**
 * Class UpdateAbstract
 * @package Apatis\SimpleDB\Abstracts\QueryBuilder
 */
abstract class UpdateAbstract extends ConditionalQueryAbstract implements UpdateInterface
{
    /**
     * @var string
     */
    protected $table;

    /**
     * @var array
     */
    protected $values = [];

    /**
     * {@inheritdoc}
     */
    public function __construct(ConnectionInterface $connection, string $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    /**
     * {@inheritdoc}
     */
    public function getTable() : string
    {
        return $this->table;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue(string $column, $value) : UpdateInterface
    {
        $this->values[$column] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setValues(array $values) : UpdateInterface
    {
        $this->values = $values;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addValues(array $values) : UpdateInterface
    {
        $this->values = array_merge($this->values, $values);
        return $this;
    }
}
