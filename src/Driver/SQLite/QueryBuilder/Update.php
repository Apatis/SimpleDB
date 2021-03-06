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

namespace Apatis\SimpleDB\Driver\SQLite\QueryBuilder;

use Apatis\SimpleDB\Abstracts\QueryBuilder\UpdateAbstract;
use Apatis\SimpleDB\Interfaces\QueryBuilder\DeleteInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\SelectInterface;

/**
 * Class UpdateAbstract
 * @package Apatis\SimpleDB\Driver\SQLite\QueryBuilder
 */
class Update extends UpdateAbstract
{
    /**
     * {@inheritdoc}
     */
    public function toSelect(): SelectInterface
    {
        // TODO: Implement toSelect() method.
        $select = new Select(
            $this->connection,
            $this->getTable(),
            ['*']
        );
        return $select;
    }

    /**
     * {@inheritdoc}
     */
    public function toDelete(): DeleteInterface
    {
        // TODO: Implement toDelete() method.
        $select = new Delete(
            $this->connection,
            $this->getTable()
        );
        return $select;
    }
}
