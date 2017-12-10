<?php
/**
 * MIT License
 *
 * Copyright (c) 2017, Pentagonal Development
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

namespace Apatis\SimpleDB;

use Apatis\SimpleDB\Abstracts\AdapterAbstract;
use Apatis\SimpleDB\Interfaces\ConnectionInterface;
use Apatis\SimpleDB\Interfaces\AdapterInterface;

/**
 * Class Connection
 * @package Apatis\SimpleDB
 */
class Connection extends \PDO implements ConnectionInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * Connection constructor.
     *
     * @param string $dsn
     * @param string $username [optional]
     * @param string $password [optional]
     * @param array $options [optional]
     * @param AdapterAbstract $driver
     */
    public function __construct(
        $dsn,
        $username = null,
        $password = null,
        $options = null,
        AdapterAbstract $driver
    ) {
        $this->adapter = $driver;
        parent::__construct($dsn, $username, $password, $options);
    }

    /**
     * @param string $statement
     * @param array $options
     *
     * @return \PDOStatement
     */
    public function prepare($statement, $options = null)
    {
        return parent::prepare($statement, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function execPrepare(string $statement, array $binds = [], array $options = null) : \PDOStatement
    {
        $stmt = $this->prepare($statement, $options);
        $stmt->execute($binds);
        return $stmt;
    }

    /**
     * @param string $statement
     * @param int $mode
     * @param null $arg3
     * @param array $ctorargs
     *
     * @return mixed|\PDOStatement
     */
    public function query($statement = null, $mode = \PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null, array $ctorargs = [])
    {
        return call_user_func_array('parent::query', func_get_args());
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter() : AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function quoteIdentifier(string $id): string
    {
        $identifier = $this->getAdapter()->getIdentifier();
        if (!$identifier) {
            return $id;
        }
        $array = explode('.', $id);
        foreach ($array as $key => $v) {
            $v = trim($v);
            if ($v == '') {
                continue;
            }
            $array[$key] = trim($v, $identifier);
        }

        return implode('.', $array);
    }
}
