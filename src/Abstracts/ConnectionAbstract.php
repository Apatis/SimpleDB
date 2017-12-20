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
use Apatis\SimpleDB\Interfaces\AdapterInterface;
use Apatis\SimpleDB\Statement;

/**
 * Class ConnectionAbstract
 * @package Apatis\SimpleDB
 * Extending such as @uses PDO
 */
abstract class ConnectionAbstract implements ConnectionInterface
{
    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * ConnectionAbstract constructor.
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
        AdapterAbstract $driver = null
    ) {
        if (!$driver) {
            throw new \RuntimeException(
                'Driver could not be empty'
            );
        }

        $this->adapter = $driver;
        $this->pdo = new \PDO($dsn, $username, $password, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function execPrepare(string $statement, array $binds = [], array $options = null) : \PDOStatement
    {
        $options = $options === null ? [] : $options;
        if (!$this->getAttribute(\PDO::ATTR_PERSISTENT)) {
            // if not persistent set into statement
            $options[\PDO::ATTR_STATEMENT_CLASS] = [Statement::class, [$this->adapter]];
        }

        $stmt = $this->prepare($statement, $options);
        $stmt->execute($binds);
        return $stmt;
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
    public function quoteIdentifier(string $id) : string
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

    /**
     * {@inheritdoc}
     */
    public function prepare($statement, $options = null) : \PDOStatement
    {
        return call_user_func_array([$this->pdo, 'prepare'], func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function beginTransaction() : bool
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * {@inheritdoc}
     */
    public function commit() : bool
    {
        return $this->pdo->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function rollBack() : bool
    {
        return $this->pdo->rollBack();
    }

    /**
     * {@inheritdoc}
     */
    public function inTransaction() : bool
    {
        return $this->pdo->inTransaction();
    }

    /**
     * {@inheritdoc}
     */
    public function setAttribute($attribute, $value) : bool
    {
        return $this->pdo->setAttribute($attribute, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function exec($query) : int
    {
        return $this->pdo->exec($query);
    }

    /**
     * {@inheritdoc}
     */
    public function query($statement = null, $mode = \PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null, array $ctorargs = [])
    {
        return call_user_func_array([$this->pdo, 'query'], func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function lastInsertId($name = null)
    {
        return $this->pdo->lastInsertId($name);
    }

    /**
     * {@inheritdoc}
     */
    public function errorCode()
    {
        return $this->pdo->errorCode();
    }

    /**
     * {@inheritdoc}
     */
    public function errorInfo() : array
    {
        return $this->pdo->errorInfo();
    }

    /**
     * {@inheritdoc}
     */
    public function getAttribute($attribute)
    {
        return $this->pdo->getAttribute($attribute);
    }

    /**
     * {@inheritdoc}
     */
    public function quote($string, $parameter_type = \PDO::PARAM_STR) : string
    {
        return $this->pdo->quote($string, $parameter_type);
    }

    /**
     * {@inheritdoc}
     */
    public static function getAvailableDrivers() : array
    {
        return \PDO::getAvailableDrivers();
    }

    /**
     * {@inheritdoc}
     */
    public function __wakeup()
    {
        $this->pdo->__wakeup();
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        $this->pdo->__sleep();
    }
}
