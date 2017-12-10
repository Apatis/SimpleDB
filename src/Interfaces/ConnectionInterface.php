<?php
/**
 * MIT License
 *
 * Copyright(c) 2017, Pentagonal Development
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files(the "Software"), to deal
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

namespace Apatis\SimpleDB\Interfaces;

use Apatis\SimpleDB\Abstracts\AdapterAbstract;

/**
 * Interface ConnectionInterface
 * @package Apatis\SimpleDB\Interfaces
 */
interface ConnectionInterface
{
    // Database config name
    const DB_DRIVER = 'driver';
    const DB_HOST = 'host';
    const DB_USER = 'user';
    const DB_PASS = 'password';
    const DB_NAME = 'db_name';
    const DB_PORT = 'port';
    const DB_PATH = 'path';
    const DB_CHARSET = 'charset';
    const DB_SOCKET  = 'socket';
    const DB_UNIX_SOCKET  = 'unix_socket';
    const DB_SSL       = 'ssl_mode';
    const DB_SSL_MODE  = 'ssl_mode';
    const DB_OPTIONS   = 'options';

    /**
     * Db value
     * @type string
     */
    const DB_VALUE_MEMORY = ':memory:';

    /**
     * Creates an instance representing a connection to a database
     *
     * @param string $dsn
     * @param $username [optional]
     * @param $password [optional]
     * @param $options [optional]
     * @param AdapterAbstract $driver
     */
    public function __construct($dsn, $username = null, $password = null, $options = null, AdapterAbstract $driver);

    /**
     * Get Fallback Driver
     *
     * @return AdapterInterface
     */
    public function getAdapter() : AdapterInterface;

    /**
     * Prepares a statement for execution and returns a statement object
     *
     * @param string $statement
     * @param array $options
     *
     * @return \PDOStatement|bool
     */
    public function prepare($statement, $options = null);

    /**
     * Initiates a transaction
     *
     * @return bool
     */
    public function beginTransaction();

    /**
     * Commits a transaction
     *
     * @return bool
     */
    public function commit();

    /**
     * Rolls back a transaction
     *
     * @return bool
     */
    public function rollBack();

    /**
     * Checks if inside a transaction
     *
     * @return mixed
     */
    public function inTransaction();

    /**
     * Set an attribute
     *
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public function setAttribute($attribute, $value);

    /**
     * Execute an SQL statement and return the number of affected rows
     *
     * @param string $query
     *
     * @return int
     */
    public function exec($query);

    /**
     * Executes an SQL statement, returning a result set as a PDOStatement object
     *
     * @param string $statement
     * @param int $mode
     * @param mixed $arg3
     * @param array $ctorargs
     *
     * @return \PDOStatement
     */
    public function query();

    /**
     * Returns the ID of the last inserted row or sequence value
     *
     * @link http://php.net/manual/en/pdo.lastinsertid.php
     * @param string $name [optional]
     * @return string
     */
    public function lastInsertId($name = null);

    /**
     * Fetch the SQLSTATE associated with the last operation on the database handle
     * @link http://php.net/manual/en/pdo.errorcode.php
     *
     * @return mixed|null an SQLSTATE, a five characters alphanumeric identifier defined in
     * the ANSI SQL-92 standard. Briefly, an SQLSTATE consists of a
     * two characters class value followed by a three characters subclass value. A
     * class value of 01 indicates a warning and is accompanied by a return code
     * of SQL_SUCCESS_WITH_INFO. Class values other than '01', except for the
     * class 'IM', indicate an error. The class 'IM' is specific to warnings
     * and errors that derive from the implementation of PDO(or perhaps ODBC,
     * if you're using the ODBC driver) itself. The subclass value '000' in any
     * class indicates that there is no subclass for that SQLSTATE.
     */
    public function errorCode();

    /**
     * Fetch extended error information associated with the last operation on the database handle
     * @link http://php.net/manual/en/pdo.errorinfo.php
     *
     * @return array <b>PDO::errorInfo</b> returns an array of error information
     * about the last operation performed by this database handle. The array
     * consists of the following fields:
     */
    public function errorInfo();

    /**
     * Retrieve a database connection attribute
     * @link http://php.net/manual/en/pdo.getattribute.php
     *
     * @param int $attribute
     * One of the PDO::ATTR_* constants. The constants that
     * apply to database connections are as follows:
     * PDO::ATTR_AUTOCOMMIT
     * PDO::ATTR_CASE
     * PDO::ATTR_CLIENT_VERSION
     * PDO::ATTR_CONNECTION_STATUS
     * PDO::ATTR_DRIVER_NAME
     * PDO::ATTR_ERRMODE
     * PDO::ATTR_ORACLE_NULLS
     * PDO::ATTR_PERSISTENT
     * PDO::ATTR_PREFETCH
     * PDO::ATTR_SERVER_INFO
     * PDO::ATTR_SERVER_VERSION
     * PDO::ATTR_TIMEOUT
     *
     * @return mixed A successful call returns the value of the requested PDO attribute.
     * An unsuccessful call returns null.
     */
    public function getAttribute($attribute);

    /**
     *(PHP 5 &gt;= 5.1.0, PECL pdo &gt;= 0.2.1)<br/>
     * Quotes a string for use in a query.
     * @link http://php.net/manual/en/pdo.quote.php
     * @param string $string <p>
     * The string to be quoted.
     * </p>
     * @param int $parameter_type [optional] <p>
     * Provides a data type hint for drivers that have alternate quoting styles.
     * </p>
     * @return string a quoted string that is theoretically safe to pass into an
     * SQL statement. Returns <b>FALSE</b> if the driver does not support quoting in
     * this way.
     */
    public function quote($string, $parameter_type = \PDO::PARAM_STR);

    /**
     * Return an array of available PDO drivers
     *
     * @return array returns an array of PDO driver names. If no drivers are available, it returns an empty array.
     */
    public static function getAvailableDrivers();
    public function __wakeup();
    public function __sleep();

    /**
     * @param string $id
     *
     * @return string
     */
    public function quoteIdentifier(string $id) : string;

    /**
     * Execute with prepare options
     *
     * @param string $statement
     * @param array $binds
     * @param array|null $options
     *
     * @return \PDOStatement
     */
    public function execPrepare(string $statement, array $binds = [], array $options = null) : \PDOStatement;
}
