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

namespace Apatis\SimpleDB\Driver\MySQL;

use Apatis\SimpleDB\Abstracts\ConnectionAbstract;

/**
 * Class Connection
 * @package Apatis\SimpleDB\Driver\MySQL
 */
class Connection extends ConnectionAbstract
{
    const MYSQL_ATTR_USE_BUFFERED_QUERY = 1000;
    const MYSQL_ATTR_LOCAL_INFILE = 1001;
    const MYSQL_ATTR_INIT_COMMAND = 1002;
    const MYSQL_ATTR_MAX_BUFFER_SIZE = 1005;
    const MYSQL_ATTR_READ_DEFAULT_FILE = 1003;
    const MYSQL_ATTR_READ_DEFAULT_GROUP = 1004;
    const MYSQL_ATTR_COMPRESS = 1006;
    const MYSQL_ATTR_DIRECT_QUERY = 1007;
    const MYSQL_ATTR_FOUND_ROWS = 1008;
    const MYSQL_ATTR_IGNORE_SPACE = 1009;
    const MYSQL_ATTR_SSL_KEY = 1010;
    const MYSQL_ATTR_SSL_CERT = 1011;
    const MYSQL_ATTR_SSL_CA = 1012;
    const MYSQL_ATTR_SSL_CAPATH = 1013;
    const MYSQL_ATTR_SSL_CIPHER = 1014;

    const MYSQL_ATTR_MULTI_STATEMENTS = 1015;
}
