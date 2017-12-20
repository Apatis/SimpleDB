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
     * Follow PDO Constant
     * @see \PDO
     * @link http://php.net/manual/en/pdo.constants.php
     */
    const PARAM_BOOL = \PDO::PARAM_BOOL;
    const PARAM_NULL = \PDO::PARAM_NULL;
    const PARAM_INT = \PDO::PARAM_INT;
    const PARAM_STR = \PDO::PARAM_STR;
    const PARAM_LOB = \PDO::PARAM_LOB;
    const PARAM_STMT = \PDO::PARAM_STMT;
    const PARAM_INPUT_OUTPUT = \PDO::PARAM_INPUT_OUTPUT;
    const PARAM_EVT_ALLOC = \PDO::PARAM_EVT_ALLOC;
    const PARAM_EVT_FREE = \PDO::PARAM_EVT_FREE;
    const PARAM_EVT_EXEC_PRE = \PDO::PARAM_EVT_EXEC_PRE;
    const PARAM_EVT_EXEC_POST = \PDO::PARAM_EVT_EXEC_POST;
    const PARAM_EVT_FETCH_PRE = \PDO::PARAM_EVT_FETCH_PRE;
    const PARAM_EVT_FETCH_POST = \PDO::PARAM_EVT_FETCH_POST;
    const PARAM_EVT_NORMALIZE = \PDO::PARAM_EVT_NORMALIZE;
    const FETCH_LAZY = \PDO::FETCH_LAZY;
    const FETCH_ASSOC = \PDO::FETCH_ASSOC;
    const FETCH_NUM = \PDO::FETCH_NUM;
    const FETCH_BOTH = \PDO::FETCH_BOTH;
    const FETCH_OBJ = \PDO::FETCH_OBJ;
    const FETCH_BOUND = \PDO::FETCH_BOUND;
    const FETCH_COLUMN = \PDO::FETCH_COLUMN;
    const FETCH_CLASS = \PDO::FETCH_CLASS;
    const FETCH_INTO = \PDO::FETCH_INTO;
    const FETCH_FUNC = \PDO::FETCH_FUNC;
    const FETCH_GROUP = \PDO::FETCH_GROUP;
    const FETCH_UNIQUE = \PDO::FETCH_UNIQUE;
    const FETCH_KEY_PAIR = \PDO::FETCH_KEY_PAIR;
    const FETCH_CLASSTYPE = \PDO::FETCH_CLASSTYPE;
    const FETCH_SERIALIZE = \PDO::FETCH_SERIALIZE;
    const FETCH_PROPS_LATE = \PDO::FETCH_PROPS_LATE;
    const FETCH_NAMED = \PDO::FETCH_NAMED;
    const ATTR_AUTOCOMMIT = \PDO::ATTR_AUTOCOMMIT;
    const ATTR_PREFETCH = \PDO::ATTR_PREFETCH;
    const ATTR_TIMEOUT = \PDO::ATTR_TIMEOUT;
    const ATTR_ERRMODE = \PDO::ATTR_ERRMODE;
    const ATTR_SERVER_VERSION = \PDO::ATTR_SERVER_VERSION;
    const ATTR_CLIENT_VERSION = \PDO::ATTR_CLIENT_VERSION;
    const ATTR_SERVER_INFO = \PDO::ATTR_SERVER_INFO;
    const ATTR_CONNECTION_STATUS = \PDO::ATTR_CONNECTION_STATUS;
    const ATTR_CASE = \PDO::ATTR_CASE;
    const ATTR_CURSOR_NAME = \PDO::ATTR_CURSOR_NAME;
    const ATTR_CURSOR = \PDO::ATTR_CURSOR;
    const ATTR_ORACLE_NULLS = \PDO::ATTR_ORACLE_NULLS;
    const ATTR_PERSISTENT = \PDO::ATTR_PERSISTENT;
    const ATTR_STATEMENT_CLASS = \PDO::ATTR_STATEMENT_CLASS;
    const ATTR_FETCH_TABLE_NAMES = \PDO::ATTR_FETCH_TABLE_NAMES;
    const ATTR_FETCH_CATALOG_NAMES = \PDO::ATTR_FETCH_CATALOG_NAMES;
    const ATTR_DRIVER_NAME = \PDO::ATTR_DRIVER_NAME;
    const ATTR_STRINGIFY_FETCHES = \PDO::ATTR_STRINGIFY_FETCHES;
    const ATTR_MAX_COLUMN_LEN = \PDO::ATTR_MAX_COLUMN_LEN;
    const ATTR_EMULATE_PREPARES = \PDO::ATTR_EMULATE_PREPARES;
    const ATTR_DEFAULT_FETCH_MODE = \PDO::ATTR_DEFAULT_FETCH_MODE;
    const ERRMODE_SILENT = \PDO::ERRMODE_SILENT;
    const ERRMODE_WARNING = \PDO::ERRMODE_WARNING;
    const ERRMODE_EXCEPTION = \PDO::ERRMODE_EXCEPTION;
    const CASE_NATURAL = \PDO::CASE_NATURAL;
    const CASE_LOWER = \PDO::CASE_LOWER;
    const CASE_UPPER = \PDO::CASE_UPPER;
    const NULL_NATURAL = \PDO::NULL_NATURAL;
    const NULL_EMPTY_STRING = \PDO::NULL_EMPTY_STRING;
    const NULL_TO_STRING = \PDO::NULL_TO_STRING;
    const ERR_NONE = \PDO::ERR_NONE;
    const FETCH_ORI_NEXT = \PDO::FETCH_ORI_NEXT;
    const FETCH_ORI_PRIOR = \PDO::FETCH_ORI_PRIOR;
    const FETCH_ORI_FIRST = \PDO::FETCH_ORI_FIRST;
    const FETCH_ORI_LAST = \PDO::FETCH_ORI_LAST;
    const FETCH_ORI_ABS = \PDO::FETCH_ORI_ABS;
    const FETCH_ORI_REL = \PDO::FETCH_ORI_REL;
    const CURSOR_FWDONLY = \PDO::CURSOR_FWDONLY;
    const CURSOR_SCROLL = \PDO::CURSOR_SCROLL;

    /**
     * Database value
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
    public function __construct(
        $dsn,
        $username = null,
        $password = null,
        $options = null,
        AdapterAbstract $driver = null
    );

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
    public function prepare($statement, $options = null) : \PDOStatement;

    /**
     * Initiates a transaction
     *
     * @return bool
     */
    public function beginTransaction() : bool;

    /**
     * Commits a transaction
     *
     * @return bool
     */
    public function commit() : bool;

    /**
     * Rolls back a transaction
     *
     * @return bool
     */
    public function rollBack() : bool;

    /**
     * Checks if inside a transaction
     *
     * @return mixed
     */
    public function inTransaction() : bool;

    /**
     * Set an attribute
     *
     * @param int $attribute
     * @param mixed $value
     * @return bool
     */
    public function setAttribute($attribute, $value) : bool;

    /**
     * Execute an SQL statement and return the number of affected rows
     *
     * @param string $query
     *
     * @return int
     */
    public function exec($query) : int;

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
    public function query($statement = null, $mode = \PDO::ATTR_DEFAULT_FETCH_MODE, $arg3 = null, array $ctorargs = []);

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
     * @return array PDO::errorInfo returns an array of error information
     * about the last operation performed by this database handle. The array
     * consists of the following fields:
     */
    public function errorInfo() : array;

    /**
     * Retrieve a database connection attribute
     * @link http://php.net/manual/en/pdo.getattribute.php
     *
     * @param int $attribute
     * One of the PDO::ATTR_* constants. The constants that
     * apply to database connections are as follows:
     * \PDO::ATTR_AUTOCOMMIT
     * \PDO::ATTR_CASE
     * \PDO::ATTR_CLIENT_VERSION
     * \PDO::ATTR_CONNECTION_STATUS
     * \PDO::ATTR_DRIVER_NAME
     * \PDO::ATTR_ERRMODE
     * \PDO::ATTR_ORACLE_NULLS
     * \PDO::ATTR_PERSISTENT
     * \PDO::ATTR_PREFETCH
     * \PDO::ATTR_SERVER_INFO
     * \PDO::ATTR_SERVER_VERSION
     * \PDO::ATTR_TIMEOUT
     *
     * @return mixed A successful call returns the value of the requested PDO attribute.
     * An unsuccessful call returns null.
     */
    public function getAttribute($attribute);

    /**
     * Quotes a string for use in a query.
     * @link http://php.net/manual/en/pdo.quote.php
     * @param string $string
     * The string to be quoted.
     *
     * @param int $parameter_type [optional]
     * Provides a data type hint for drivers that have alternate quoting styles.
     *
     * @return string a quoted string that is theoretically safe to pass into an
     * SQL statement. Returns FALSE if the driver does not support quoting in
     * this way.
     */
    public function quote($string, $parameter_type = \PDO::PARAM_STR) : string;

    /**
     * Return an array of available PDO drivers
     *
     * @return array returns an array of PDO driver names. If no drivers are available, it returns an empty array.
     */
    public static function getAvailableDrivers() : array;

    /**
     * @see \PDO::__wakeup();
     */
    public function __wakeup();

    /**
     * @see \PDO::__sleep();
     */
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
