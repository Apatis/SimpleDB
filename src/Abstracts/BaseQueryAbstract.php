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

namespace Apatis\SimpleDB\Abstracts;

use Apatis\SimpleDB\Interfaces\ConnectionInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\BaseQueryInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\ResultInterface;
use Apatis\SimpleDB\Result;

/**
 * Class BaseQueryAbstract
 * @package Apatis\SimpleDB\Abstracts
 */
abstract class BaseQueryAbstract implements BaseQueryInterface
{
    /**
     * @var array
     */
    protected $params = [];
    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Get Connection
     *
     * @return ConnectionInterface
     */
    public function getConnection() : ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * {@inheritdoc}
     */
    public function setParams(array $params) : BaseQueryInterface
    {
        $this->params = $params;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function addParams(array $params) : BaseQueryInterface
    {
        $this->params = array_merge($this->params, $params);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setParam(string $param, $value) : BaseQueryInterface
    {
        $this->params[$param] = $value;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * {@inheritdoc}
     */
    public function clearParams() : BaseQueryInterface
    {
        // use set params
        $this->setParams([]);
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeParam(string $param) : bool
    {
        if (isset($this->params[$param])) {
            unset($this->params[$param]);
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function toSQL() : string
    {
        $result = '';
        // TODO: Implement toSQL() method.
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function execute() : \PDOStatement
    {
        $stmt = $this
            ->getConnection()
            ->execPrepare(
                $this->toSQL(),
                $this->getParams()
            );

        return $stmt;
    }
}
