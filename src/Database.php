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

declare(strict_types=1);

namespace Apatis\SimpleDB;

use Apatis\SimpleDB\Abstracts\AdapterAbstract;
use Apatis\SimpleDB\Driver\MySQL\Adapter as MYSQL_ADAPTER;
use Apatis\SimpleDB\Driver\SQLite\Adapter as SQLITE_ADAPTER;
use Apatis\SimpleDB\Driver\PgSQL\Adapter as PG_ADAPTER;
use Apatis\SimpleDB\Exceptions\DriverNotSupportedException;
use Apatis\SimpleDB\Exceptions\InvalidConfigurationExceptions;
use Apatis\SimpleDB\Interfaces\ConnectionInterface;

/** @noinspection PhpHierarchyChecksInspection */
/**
 * Class Database
 * @package Apatis\SimpleDB
 * @mixin AdapterAbstract
 */
class Database
{
    /**
     * @var array
     */
    protected static $driversAdapter = [
        'mysql'  => MYSQL_ADAPTER::class,
        'pgsql'  => PG_ADAPTER::class,
        'sqlite' => SQLITE_ADAPTER::class,
        'oci'    => null,
        'sqlsrv' => null,
        'ibm'    => null,
    ];

    /**
     * @var AdapterAbstract
     */
    private $adapter;

    /**
     * @var array
     */
    private $originalOptions;

    /**
     * Database constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->originalOptions = $options;
    }

    /**
     * Get available drivers
     *
     * @return array
     */
    public static function getAvailableDrivers() : array
    {
        return array_keys(static::$driversAdapter);
    }

    /**
     * @return Database
     */
    public function connect() : Database
    {
        if (! $this->adapter) {
            $this->adapter = $this->createAdapterConnection($this->originalOptions);
        }

        return $this;
    }

    /**
     * @param array $options
     *
     * @return AdapterAbstract
     * @throws InvalidConfigurationExceptions
     * @throws DriverNotSupportedException if driver is not supported
     */
    private function createAdapterConnection(array $options) : AdapterAbstract
    {
        $driverName = ! isset($options[ConnectionInterface::DB_DRIVER])
            ? null
            : $options[ConnectionInterface::DB_DRIVER];
        // check adapter as key name if driver does not exists
        if ($driverName === null && isset($options['adapter'])) {
            $tmpDriver = $options['adapter'];
            if (is_string($tmpDriver) && ($tmpDriver = $this->normalizeDriver($tmpDriver))) {
                $driverName = $tmpDriver;
                unset($tmpDriver);
            }
        }

        if ($driverName === null) {
            throw new InvalidConfigurationExceptions(
                'Database driver has not been set'
            );
        }

        if (! is_string($driverName)) {
            throw new InvalidConfigurationExceptions(
                sprintf(
                    'Database driver must be as a string %s given',
                    gettype($driverName)
                )
            );
        }

        $oldDriver   = $driverName;
        $driverName = $this->normalizeDriver($driverName);
        if (! $driverName || ! isset(self::$driversAdapter[$driverName])) {
            throw new DriverNotSupportedException($oldDriver);
        }

        $adapterClass                            = self::$driversAdapter[$driverName];
        $options[ConnectionInterface::DB_DRIVER] = $driverName;

        /**
         * @var AdapterAbstract $adapter
         */
        $adapter = new $adapterClass($options);
        $adapter->connect();

        return $adapter;
    }

    /**
     * Normalize Driver
     *
     * @param string $adapter
     *
     * @return null|string
     */
    public function normalizeDriver(string $adapter)
    {
        preg_match('`
            (?P<pgsql>(?:pgsql|postg))
            | (?P<sqlite>s?q?lite)
            | (?P<mysql>sql)

            # add for future driver
            | (?P<odbc>odbc)
            | (?P<ibm>db2|ibm)
            | (?P<sqlsrv>srv|mssql)
            | (?P<oci>oci)
        `xi', $adapter, $match);
        $adapter = null;
        foreach ($match as $key => $value) {
            if (! is_int($key) && ! empty($value)) {
                $adapter = $key;
                break;
            }
        }

        return $adapter;
    }

    /**
     * @param ConnectionInterface $connection
     *
     * @return AdapterAbstract
     */
    public function withConnection(ConnectionInterface $connection) : AdapterAbstract
    {
        $object          = clone $this;
        $object->adapter = $this->adapter->withConnection($connection);

        return $object;
    }

    /**
     * @return AdapterAbstract
     */
    public function getAdapter() : AdapterAbstract
    {
        return $this->connect()->adapter;
    }

    /**
     * Magic Method
     *
     * @uses AdapterAbstract
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->getAdapter(), $name], $arguments);
    }
}
