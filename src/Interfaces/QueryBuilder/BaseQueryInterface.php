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

namespace Apatis\SimpleDB\Interfaces\QueryBuilder;

/**
 * Interface BaseQueryInterface
 * @package Apatis\SimpleDB\Interfaces\QueryBuilder
 */
interface BaseQueryInterface
{
    /**
     * Set params array override params
     *
     * @param array $params
     *
     * @return static|BaseQueryInterface
     */
    public function setParams(array $params): BaseQueryInterface;

    /**
     * Add merge Params
     *
     * @param array $params
     *
     * @return static|BaseQueryInterface
     */
    public function addParams(array $params): BaseQueryInterface;

    /**
     * @param string $param
     * @param string|null|bool $value
     *
     * @return static|BaseQueryInterface
     */
    public function setParam(string $param, $value) : BaseQueryInterface;

    /**
     * Get All params
     *
     * @return array
     */
    public function getParams() : array;

    /**
     * Clear params
     *
     * @return static|BaseQueryInterface
     */
    public function clearParams() : BaseQueryInterface;

    /**
     * Remove Existing params
     *
     * @param string $param
     *
     * @return bool true if success otherwise false
     */
    public function removeParam(string $param) : bool;

    /**
     * Generate SQL
     *
     * @return string
     */
    public function toSQL() : string;

    /**
     * @return ResultInterface
     */
    public function execute() : \PDOStatement;
}
