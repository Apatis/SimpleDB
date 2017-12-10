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

namespace Apatis\SimpleDB\Adapter;

use Apatis\SimpleDB\Abstracts\AdapterAbstract;

/** @noinspection PhpHierarchyChecksInspection */
/**
 * Class MySQL
 * @package Apatis\SimpleDB\Adapter
 * MySQL Adapter
 */
class MySQL extends AdapterAbstract
{
    /**
     * @type string adapter / driver
     */
    const ADAPTER_NAME = 'mysql';

    /**
     * {@inheritdoc}
     */
    protected $identifier = '`';

    /**
     * @return null|string
     */
    public function getDbName()
    {
        return $this->getConnection()->query("SELECT CURRENT_DATABASE();")->fetchColumn();
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareOptions(array $options): array
    {
        $options = parent::prepareOptions($options);
        unset($options[\PDO::ATTR_AUTOCOMMIT]);
        return $options;
    }

    /**
     * {@inheritdoc}
     */
    public function getInfo() : array
    {
        $this->info                     = parent::getInfo();
        $this->info['serverVersion']    = $this->getAttribute(\PDO::ATTR_SERVER_VERSION);
        $this->info['clientVersion']    = $this->getAttribute(\PDO::ATTR_CLIENT_VERSION);
        $this->info['connectionStatus'] = $this->getAttribute(\PDO::ATTR_CONNECTION_STATUS);
        $this->info['serverInfo']       = $this->getAttribute(\PDO::ATTR_SERVER_INFO);
        foreach (explode('  ', $this->info['serverInfo']) as $value) {
            $value = explode(':', $value);
            $key   = trim(array_shift($value));
            $value = trim(implode(':', $value));
            if (is_numeric($value)) {
                $value = abs($value);
            }
            $key = preg_replace_callback(
                '/\s+([a-z])?/i',
                function($c) {
                    return isset($c[1]) ? strtoupper($c[1]) : '';
                },
                strtolower($key)
            );
            $this->info['serverInfoDetail'][$key] = $value;
        }

        return $this->info;
    }
}
