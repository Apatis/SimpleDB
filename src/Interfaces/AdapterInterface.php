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

namespace Apatis\SimpleDB\Interfaces;

use Apatis\SimpleDB\Abstracts\AdapterAbstract;

/**
 * Interface AdapterInterface
 * @package Apatis\SimpleDB\Interfaces
 */
interface AdapterInterface
{
    /**
     * Get options set
     *
     * @return array
     */
    public function getOptions() : array;

    /**
     * Get Option
     *
     * @param string $name
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    public function getOption($name, $default = null);

    /**
     * @return AdapterAbstract
     */
    public function ping() : AdapterAbstract;

    /**
     * @return bool
     */
    public function isConnected() : bool;

    /**
     * Get Adapter name
     *
     * @return string
     */
    public function getAdapterName() : string;

    /**
     * Get driver name ( real driver name from do attribute )
     *
     * @return string
     */
    public function getDriverName() : string;

    /**
     * @return ConnectionInterface
     */
    public function getConnection() : ConnectionInterface;

    /**
     * @return array
     */
    public function getInfo() : array;

    /**
     * @return string
     */
    public function getDSN() : string;

    /**
     * Database Table / Column delimiter
     *
     * @return string
     */
    public function getIdentifier() : string;

    /**
     * Clone connection and use new Connection from param
     *
     * @param ConnectionInterface $connection
     *
     * @return AdapterAbstract
     */
    public function withConnection(ConnectionInterface $connection) : AdapterAbstract;

    /**
     * @return string|null
     */
    public function getDbName();
}
