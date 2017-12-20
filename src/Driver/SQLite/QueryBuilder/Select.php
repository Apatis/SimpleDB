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

use Apatis\SimpleDB\Abstracts\QueryBuilder\SelectAbstract;
use Apatis\SimpleDB\Interfaces\QueryBuilder\DeleteInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\SelectInterface;
use Apatis\SimpleDB\Interfaces\QueryBuilder\UpdateInterface;

/**
 * Class SelectAbstract
 * @package Apatis\SimpleDB\Driver\SQLite\QueryBuilder
 */
class Select extends SelectAbstract
{
    /**
     * {@inheritdoc}
     */
    public function getHavingQuery()
    {
        $having = '';
        // TODO: Implement getHavingQuery() method.
        return $having;
    }

    /**
     * {@inheritdoc}
     */
    public function asCount(string $alias = 'c') : SelectInterface
    {
        // TODO: Implement asCount() method.
        $object = clone $this;

        return $object;
    }

    /**
     * {@inheritdoc}
     */
    public function toUpdate() : UpdateInterface
    {
        // TODO: Implement toUpdate() method.
        $update = new Update(
            $this->connection,
            $this->table
        );

        return $update;
    }

    /**
     * {@inheritdoc}
     */
    public function toDelete() : DeleteInterface
    {
        // TODO: Implement toDelete() method.
        $delete = new Delete(
            $this->connection,
            $this->getTable()
        );
        return $delete;
    }
}
