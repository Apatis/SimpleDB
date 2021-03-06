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
use Apatis\SimpleDB\Interfaces\AdapterInterface;

/**
 * Class Statement
 * @package Apatis\SimpleDB
 */
class Statement extends \PDOStatement
{
    /**
     * @var AdapterAbstract
     */
    private $adapter;

    /**
     * @var mixed
     */
    private $resultValue;

    /**
     * Statement constructor.
     *
     * @param AdapterAbstract $adapter
     */
    private function __construct(AdapterAbstract $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($input_parameter = null)
    {
        $this->resultValue = func_num_args() !== 0
            ? parent::execute($input_parameter)
            : parent::execute();

        return $this->resultValue;
    }

    /**
     * @return AdapterInterface
     */
    public function getAdapter() : AdapterInterface
    {
        return $this->adapter;
    }

    /**
     * @return mixed
     */
    public function getResultValue()
    {
        return $this->resultValue;
    }
}
