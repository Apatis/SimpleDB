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

namespace Apatis\SimpleDB\Driver\PgSQL;

use Apatis\SimpleDB\Abstracts\ConnectionAbstract;

/**
 * Class Connection
 * @package Apatis\SimpleDB\Driver\PgSQL
 */
class Connection extends ConnectionAbstract
{
    /**
     * @link http://php.net/manual/en/pgsql.constants.php
     */
    const PGSQL_ASSOC = 1;
    const PGSQL_ATTR_DISABLE_NATIVE_PREPARED_STATEMENT = 1000;
    const PGSQL_BAD_RESPONSE = 5;
    const PGSQL_BOTH = 3;
    const PGSQL_TRANSACTION_IDLE = 0;
    const PGSQL_TRANSACTION_ACTIVE = 1;
    const PGSQL_TRANSACTION_INTRANS = 2;
    const PGSQL_TRANSACTION_INERROR = 3;
    const PGSQL_TRANSACTION_UNKNOWN = 4;

    const PGSQL_CONNECT_ASYNC = 4;
    const PGSQL_CONNECT_FORCE_NEW = 2;
    const PGSQL_CONNECTION_AUTH_OK = 5;
    const PGSQL_CONNECTION_AWAITING_RESPONSE = 4;
    const PGSQL_CONNECTION_BAD = 1;
    const PGSQL_CONNECTION_OK = 0;
    const PGSQL_CONNECTION_MADE = 3;
    const PGSQL_CONNECTION_SETENV = 6;
    const PGSQL_CONNECTION_SSL_STARTUP = 7;
    const PGSQL_CONNECTION_STARTED = 2;
    const PGSQL_COMMAND_OK = 1;
    const PGSQL_CONV_FORCE_NULL = 4;
    const PGSQL_CONV_IGNORE_DEFAULT = 2;
    const PGSQL_CONV_IGNORE_NOT_NULL = 8;
    const PGSQL_COPY_IN = 4;
    const PGSQL_COPY_OUT = 3;
    const PGSQL_DIAG_CONTEXT = 87;
    const PGSQL_DIAG_INTERNAL_POSITION = 112;
    const PGSQL_DIAG_INTERNAL_QUERY = 113;
    const PGSQL_DIAG_MESSAGE_DETAIL = 68;
    const PGSQL_DIAG_MESSAGE_HINT = 72;
    const PGSQL_DIAG_MESSAGE_PRIMARY = 77;
    const PGSQL_DIAG_SEVERITY = 83;
    const PGSQL_DIAG_SOURCE_FILE = 70;
    const PGSQL_DIAG_SOURCE_FUNCTION = 82;
    const PGSQL_DIAG_SOURCE_LINE = 76;
    const PGSQL_DIAG_SQLSTATE = 67;
    const PGSQL_DIAG_STATEMENT_POSITION = 80;
    const PGSQL_DML_ASYNC = 1024;
    const PGSQL_DML_EXEC = 512;
    const PGSQL_DML_NO_CONV = 256;
    const PGSQL_DML_STRING = 2048;
    const PGSQL_DML_ESCAPE = 4096;
    const PGSQL_EMPTY_QUERY = 0;
    const PGSQL_ERRORS_DEFAULT = 1;
    const PGSQL_ERRORS_TERSE = 0;
    const PGSQL_ERRORS_VERBOSE = 2;
    const PGSQL_FATAL_ERROR = 7;
    const PGSQL_NONFATAL_ERROR = 6;
    const PGSQL_NOTICE_ALL = 2;
    const PGSQL_NOTICE_CLEAR = 3;
    const PGSQL_NOTICE_LAST = 1;
    const PGSQL_NUM = 2;
    const PGSQL_POLLING_ACTIVE = 4;
    const PGSQL_POLLING_FAILED = 0;
    const PGSQL_POLLING_OK = 3;
    const PGSQL_POLLING_READING = 1;
    const PGSQL_POLLING_WRITING = 2;
    const PGSQL_SEEK_CUR = 1;
    const PGSQL_SEEK_END = 2;
    const PGSQL_SEEK_SET = 0;
    const PGSQL_STATUS_LONG = 1;
    const PGSQL_STATUS_STRING = 2;
    const PGSQL_TUPLES_OK = 2;
}
