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
use Apatis\SimpleDB\Adapter\MySQL;
use Apatis\SimpleDB\Adapter\PgSQL;
use Apatis\SimpleDB\Adapter\SQLite;
use Apatis\SimpleDB\Exceptions\InvalidConfigurationExceptions;
use Apatis\SimpleDB\Interfaces\ConnectionInterface;

/** @noinspection PhpHierarchyChecksInspection */
/**
 * Class Db
 * @package Apatis\SimpleDB
 * @mixin AdapterAbstract
 */
class Db
{
    /**
     * @var array
     */
    protected static $adapters = [
        'mysql'  => MySQL::class,
        'pgsql'  => PgSQL::class,
        'sqlite' => SQLite::class,
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
     * Db constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->originalOptions = $options;
    }

    /**
     * @return Db
     */
    public function connect(): Db
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
     */
    private function createAdapterConnection(array $options): AdapterAbstract
    {
        $adapterName = ! isset($options[ConnectionInterface::DB_DRIVER])
            ? null
            : $options[ConnectionInterface::DB_DRIVER];
        // check adapter as key name if driver does not exists
        if ($adapterName === null && isset($options['adapter'])) {
            $tmpDriver = $options['adapter'];
            if (is_string($tmpDriver) && ($tmpDriver = $this->normalizeAdapter($tmpDriver))) {
                $adapterName = $tmpDriver;
                unset($tmpDriver);
            }
        }

        if ($adapterName === null) {
            throw new InvalidConfigurationExceptions(
                'Database driver has not been set'
            );
        }
        if (! is_string($adapterName)) {
            throw new InvalidConfigurationExceptions(
                sprintf(
                    'Database driver must be as a string %s given',
                    gettype($adapterName)
                )
            );
        }
        $oldDriver   = $adapterName;
        $adapterName = $this->normalizeAdapter($adapterName);
        if (! $adapterName || ! isset(self::$adapters[$adapterName])) {
            throw new InvalidConfigurationExceptions(
                sprintf(
                    'Database driver %s is not exists',
                    $oldDriver
                )
            );
        }

        $adapterClass                            = self::$adapters[$adapterName];
        $options[ConnectionInterface::DB_DRIVER] = $adapterName;

        /**
         * @var AdapterAbstract $adapter
         */
        $adapter = new $adapterClass($options);
        $adapter->getConnection();

        return $adapter;
    }

    /**
     * Normalize Driver
     *
     * @param string $adapter
     *
     * @return null|string
     */
    public function normalizeAdapter(string $adapter)
    {
        preg_match('`
            (?P<pgsql>(?:pgsql|postg))
            | (?P<sqlite>s?q?lite)
            | (?P<mysql>sql)
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
    public function withConnection(ConnectionInterface $connection): AdapterAbstract
    {
        // clone new object
        $object          = clone $this;
        // set new adapter
        $object->adapter = $connection->getAdapter();

        return $object;
    }

    /**
     * @return AdapterAbstract
     */
    public function getAdapter(): AdapterAbstract
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
