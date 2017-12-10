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

namespace Apatis\SimpleDB\Abstracts;

use Apatis\SimpleDB\Connection;
use Apatis\SimpleDB\Exceptions\InvalidConfigurationExceptions;
use Apatis\SimpleDB\Interfaces\ConnectionInterface;
use Apatis\SimpleDB\Interfaces\AdapterInterface;
use Apatis\SimpleDB\Statement;

/**
 * Class AdapterAbstract
 * @package Apatis\SimpleDB\Abstracts
 *
 * @mixin ConnectionInterface
 */
abstract class AdapterAbstract implements AdapterInterface
{
    /**
     * @var string
     */
    protected $defaultHost = 'localhost';

    /**
     * @type string
     */
    const ADAPTER_NAME = null;

    /**
     * @var string
     */
    protected $identifier = '"';

    /**
     * @var string
     */
    protected $dsn;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var array
     */
    protected $originalOptions = [];

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var string
     */
    protected $queryTestConnection = 'SELECT 1';

    /**
     * @var null|string
     */
    private $initDBName = null;

    /**
     * @var array
     */
    protected $info = [
        'persistent'       => false,
        'driver'           => self::ADAPTER_NAME,
        'database'         => null,
        'clientVersion'    => null,
        'serverVersion'    => null,
        'connectionStatus' => null,
        'serverInfo'       => null,
        'serverInfoDetail' => [],
        'errorInfo'        => [
            '00000',
            null,
            null
        ]
    ];

    /**
     * AdapterAbstract constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->originalOptions                   = $options;
        $options[ConnectionInterface::DB_DRIVER] = $this->getAdapterName();
        $this->options                           = $options;
    }

    /**
     * @return bool
     */
    public function isConnected() : bool
    {
        $connection = $this->getConnection();
        $mode = $connection->getAttribute(\PDO::ATTR_ERRMODE);
        try {
            if ($mode !== \PDO::ERRMODE_EXCEPTION) {
                $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }
            $connection->query($this->queryTestConnection);
            // fallback default attribute
            if ($mode !== \PDO::ERRMODE_EXCEPTION) {
                $connection->setAttribute(\PDO::ATTR_ERRMODE, $mode);
            }
        } catch (\PDOException $e) {
            if ($mode !== \PDO::ERRMODE_EXCEPTION) {
                $connection->setAttribute(\PDO::ATTR_ERRMODE, $mode);
            }
            return false;
        }

        return true;
    }

    /**
     * @return AdapterAbstract
     */
    public function ping() : AdapterAbstract
    {
        $connection = $this->getConnection();
        $mode = $connection->getAttribute(\PDO::ATTR_ERRMODE);
        try {
            if ($mode !== \PDO::ERRMODE_EXCEPTION) {
                $connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            }

            $connection->query($this->queryTestConnection);
        } catch (\Exception $e) {
            $this->connection = null;
            $this->connection = $this->getConnection();
            $connection = $this->connection;
        }

        if ($mode !== \PDO::ERRMODE_EXCEPTION) {
            $connection->setAttribute(\PDO::ATTR_ERRMODE, $mode);
        }

        return $this;
    }

    /**
     * @return ConnectionInterface|Connection
     */
    final public function getConnection(): ConnectionInterface
    {
        if (!$this->connection) {
            $this->connection = new Connection(
                $this->getDSN(),
                $this->getOption(ConnectionInterface::DB_USER),
                $this->getOption(ConnectionInterface::DB_PASS),
                [],
                $this
            );

            $options = $this->getOption(ConnectionInterface::DB_OPTIONS, []);
            foreach ($options as $key => $value) {
                $this->connection->setAttribute($key, $value);
            }
        }

        return $this->connection;
    }

    /**
     * Constructs the MySql PDO DSN.
     *
     * @param array $options
     *
     * @return array The DSN. ['dsn' => string -> dsn, 'options' => (array) -> new options]
     */
    protected function configureDsn(array $options): array
    {
        $driver = strtolower($this->getAdapterName());
        if ($driver === '') {
            throw new InvalidConfigurationExceptions(
                "Driver is empty or unknown",
                E_USER_NOTICE
            );
        }

        $dsn = "{$driver}:";
        switch ($driver) {
            case 'sqlite':
                $path = null;
                if (isset($options[ConnectionInterface::DB_PATH])) {
                    $path = $options[ConnectionInterface::DB_PATH];
                } elseif (isset($options[ConnectionInterface::DB_NAME])) {
                    $path = $options[ConnectionInterface::DB_NAME];
                }
                if (! $path) {
                    throw new InvalidConfigurationExceptions(
                        'Database path for driver `sqlite` must be set',
                        E_USER_NOTICE
                    );
                }
                if (! is_string($path)) {
                    throw new InvalidConfigurationExceptions(
                        'Database path for driver `sqlite` is not valid',
                        E_USER_NOTICE
                    );
                }
                if (trim($path) === '') {
                    throw new InvalidConfigurationExceptions(
                        'Database path for driver `sqlite` could not be empty',
                        E_USER_NOTICE
                    );
                }
                if (strtolower(trim($path)) === ConnectionInterface::DB_VALUE_MEMORY) {
                    $path = ConnectionInterface::DB_VALUE_MEMORY;
                }

                // make full path
                $spl = new \SplFileInfo($path);
                if (!$spl->getRealPath()) {
                    if ($dirPath = $spl->getPathInfo()->getRealPath()) {
                        $spl = new \SplFileInfo($dirPath . DIRECTORY_SEPARATOR .  $spl->getBasename());
                    } else {
                        $spl = null;
                    }
                }
                $path = $spl ? (string) $spl : $path;
                unset($spl);

                /**
                 * SQLITE DB NAME & DB PATH IS SAME
                 */
                $options[ConnectionInterface::DB_PATH] = $path;
                $options[ConnectionInterface::DB_NAME] = $path;
                $dsn .= $path;
                break;
            case 'mysql':
                $options[ConnectionInterface::DB_SOCKET] = isset($options[ConnectionInterface::DB_SOCKET])
                                                           && is_string($options[ConnectionInterface::DB_SOCKET])
                                                           && trim($options[ConnectionInterface::DB_SOCKET])
                    ? $options[ConnectionInterface::DB_SOCKET]
                    : null;
                if ($options[ConnectionInterface::DB_SOCKET] === null
                    && isset($options[ConnectionInterface::DB_UNIX_SOCKET])
                ) {
                    $options[ConnectionInterface::DB_SOCKET] = $options[ConnectionInterface::DB_UNIX_SOCKET];
                }

                unset($options[ConnectionInterface::DB_UNIX_SOCKET]);
                $uniqueSocket = $options[ConnectionInterface::DB_SOCKET];
                if (! $options[ConnectionInterface::DB_SOCKET]) {
                    $uniqueSocket = null;
                    unset($options[ConnectionInterface::DB_SOCKET]);
                }
                $host = ! isset($options[ConnectionInterface::DB_HOST]) && ! $uniqueSocket
                    ? $this->defaultHost
                    : $options[ConnectionInterface::DB_HOST];

                if (! $uniqueSocket && ( ! $host || ! is_string($host))) {
                    throw new InvalidConfigurationExceptions(
                        sprintf(
                            'Database `mysql` host must be as a string %s given',
                            $host ?: 'none'
                        )
                    );
                }

                $options[ConnectionInterface::DB_HOST] = $host;
                if ($host) {
                    $dsn .= "host={$host};";
                } else {
                    unset($options[ConnectionInterface::DB_HOST]);
                }

                if ($uniqueSocket) {
                    $dsn .= "unix_socket={$options[ConnectionInterface::DB_HOST]};";
                } elseif (! isset($options[ConnectionInterface::DB_PORT])) {
                    // port
                    $options[ConnectionInterface::DB_PORT] = 3306;
                }
                if (isset($options[ConnectionInterface::DB_PORT])) {
                    $dsn .= "port={$options[ConnectionInterface::DB_PORT]};";
                }

                if (isset($options[ConnectionInterface::DB_NAME])) {
                    $dsn .= "dbname={$options[ConnectionInterface::DB_NAME]};";
                }

                if (isset($options[ConnectionInterface::DB_CHARSET])) {
                    $dsn .= "charset={$options[ConnectionInterface::DB_CHARSET]};";
                }
                break;
            case 'pgsql':
                $host = ! isset($options[ConnectionInterface::DB_HOST])
                    ? $this->defaultHost
                    : $options[ConnectionInterface::DB_HOST];
                if (! $host) {
                    throw new InvalidConfigurationExceptions(
                        sprintf(
                            'Database `mysql` host must be as a string %s given',
                            $host ?: 'none'
                        )
                    );
                }

                $dsn                                   .= "host={$host};";
                $options[ConnectionInterface::DB_HOST] = $host;
                if (! isset($options[ConnectionInterface::DB_PORT])
                     || ! $options[ConnectionInterface::DB_PORT]
                ) {
                    $options[ConnectionInterface::DB_PORT] = 5432;
                }
                if (isset($options[ConnectionInterface::DB_PORT])) {
                    $dsn .= "port={$options[ConnectionInterface::DB_PORT]};";
                }

                if (isset($options[ConnectionInterface::DB_NAME])) {
                    $dsn .= "dbname={$options[ConnectionInterface::DB_NAME]};";
                } else {
                    // Used for temporary connections to allow operations like dropping the database currently connected to.
                    // Connecting without an explicit database does not work, therefore "template1" database is used
                    // as it is certainly present in every server setup.
                    $dsn .= 'dbname=template1;';
                }
                if (isset($options[ConnectionInterface::DB_SSL_MODE])) {
                    $dsn .= "sslmode={$options[ConnectionInterface::DB_SSL_MODE]};";
                } elseif (isset($options['sslmode'])) {
                    $options[ConnectionInterface::DB_SSL_MODE] = $options['sslmode'];
                    $dsn                                       .= "sslmode={$options['sslmode']};";
                    unset($options['sslmode']);
                }
                break;
        }

        $optionsAttr = isset($options[ConnectionInterface::DB_OPTIONS])
            ? (array) $options[ConnectionInterface::DB_OPTIONS]
            : [];
        $options[ConnectionInterface::DB_OPTIONS] = $this->prepareOptions($optionsAttr);
        return [
            'dsn'     => $dsn,
            'options' => $options
        ];
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function prepareOptions(array $options) : array
    {
        unset($options[\PDO::ATTR_AUTOCOMMIT]);
        $options[\PDO::ATTR_STATEMENT_CLASS] = [ Statement::class, [$this] ];
        if (!isset($options[\PDO::ATTR_ERRMODE])) {
            $options[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;
        }
        return $options;
    }

    /**
     * Configure
     */
    final protected function configureOptions()
    {
        if (! $this->dsn) {
            $detail           = $this->configureDsn($this->options);
            $this->dsn        = $detail['dsn'];
            $this->options    = $detail['options'];
            $this->initDBName = isset($detail['options'][ConnectionInterface::DB_NAME])
                ? $detail['options'][ConnectionInterface::DB_NAME]
                : null;
        }
    }

    /**
     * @return string
     */
    public function getDSN(): string
    {
        $this->configureOptions();

        return $this->dsn;
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getAdapterName(): string
    {
        return static::ADAPTER_NAME;
    }

    /**
     * @return string
     */
    public function getDriverName() : string
    {
        return $this->getConnection()->getAttribute(\PDO::ATTR_DRIVER_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(): array
    {
        $this->configureOptions();

        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function getOption($name, $default = null)
    {
        $options = $this->getOptions();

        return array_key_exists($name, $options)
            ? $options[$name]
            : $default;
    }

    /**
     * @return array
     */
    public function getInfo() : array
    {
        $this->info['persistent'] = $this->getAttribute(\PDO::ATTR_PERSISTENT);
        $this->info['driver']     = $this->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $this->info['database']   = $this->getDbName();
        $this->info['errorInfo']  = $this->errorInfo();
        return $this->info;
    }

    /**
     * {@inheritdoc}
     */
    public function withConnection(ConnectionInterface $connection) : AdapterAbstract
    {
        $object = clone $this;
        $object->connection = $connection;
        return $object;
    }

    /**
     * @return null|string
     */
    public function getDbName()
    {
        return $this->initDBName;
    }

    /**
     * Magic Method Call
     *
     * @param string $name
     * @param array $arguments
     *
     * @return mixed
     */
    final public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->getConnection(), $name], $arguments);
    }
}
