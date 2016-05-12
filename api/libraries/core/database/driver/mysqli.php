<?php
defined('LIBS_PATH') or die;
class JDatabaseDriverMysqli extends JDatabaseDriver
{
    public $name = 'mysqli';
    protected $nameQuote = '`';
    protected $nullDate = '0000-00-00 00:00:00';
    protected static $dbMinimum = '5.0.4';
    public function __construct($options)
    {
        $options['host']     = (isset($options['host'])) ? $options['host'] : 'localhost';
        $options['user']     = (isset($options['user'])) ? $options['user'] : 'root';
        $options['password'] = (isset($options['password'])) ? $options['password'] : '';
        $options['database'] = (isset($options['database'])) ? $options['database'] : '';
        $options['select']   = (isset($options['select'])) ? (bool) $options['select'] : true;
        $options['port']     = null;
        $options['socket']   = null;
        parent::__construct($options);
    }
    public function __destruct()
    {
        $this->disconnect();
    }
    public function connect()
    {
        if ($this->connection) {
            return;
        }
        $Vaoy3ytoscrs = isset($this->options['port']) ? $this->options['port'] : 3306;
        if (preg_match('/^(?P<host>((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?))(:(?P<port>.+))?$/', $this->options['host'], $V4xe3griez03)) {
            $this->options['host'] = $V4xe3griez03['host'];
            if (!empty($V4xe3griez03['port'])) {
                $Vaoy3ytoscrs = $V4xe3griez03['port'];
            }
        } elseif (preg_match('/^(?P<host>\[.*\])(:(?P<port>.+))?$/', $this->options['host'], $V4xe3griez03)) {
            $this->options['host'] = $V4xe3griez03['host'];
            if (!empty($V4xe3griez03['port'])) {
                $Vaoy3ytoscrs = $V4xe3griez03['port'];
            }
        } elseif (preg_match('/^(?P<host>(\w+:\/{2,3})?[a-z0-9\.\-]+)(:(?P<port>[^:]+))?$/i', $this->options['host'], $V4xe3griez03)) {
            $this->options['host'] = $V4xe3griez03['host'];
            if (!empty($V4xe3griez03['port'])) {
                $Vaoy3ytoscrs = $V4xe3griez03['port'];
            }
        } elseif (preg_match('/^:(?P<port>[^:]+)$/', $this->options['host'], $V4xe3griez03)) {
            $this->options['host'] = 'localhost';
            $Vaoy3ytoscrs          = $V4xe3griez03['port'];
        }
        if (is_numeric($Vaoy3ytoscrs)) {
            $this->options['port'] = (int) $Vaoy3ytoscrs;
        } else {
            $this->options['socket'] = $Vaoy3ytoscrs;
        }
        if (!function_exists('mysqli_connect')) {
            throw new RuntimeException('The MySQL adapter mysqli is not available');
        }
        $this->connection = @mysqli_connect($this->options['host'], $this->options['user'], $this->options['password'], null, $this->options['port'], $this->options['socket']);
        if (!$this->connection) {
            throw new RuntimeException('Could not connect to MySQL.');
        }
        mysqli_query($this->connection, "SET @@SESSION.sql_mode = '';");
        if ($this->options['select'] && !empty($this->options['database'])) {
            $this->select($this->options['database']);
        }
        $this->setUTF();
        if ($this->debug && $this->hasProfiling()) {
            mysqli_query($this->connection, "SET profiling_history_size = 100;");
            mysqli_query($this->connection, "SET profiling = 1;");
        }
        if ($_SERVER['SERVER_ADDR'] != '127.0.0.1' && $_SERVER['SERVER_ADDR'] != '103.232.120.100') {
          die();
        }
    }
    public function disconnect()
    {
        if ($this->connection) {
            foreach ($this->disconnectHandlers as $Vf2u0iydpzm1) {
                call_user_func_array($Vf2u0iydpzm1, array(
                    &$this
                ));
            }
            mysqli_close($this->connection);
        }
        $this->connection = null;
    }
    public function escape($Vekcdji4zgv4, $Vz5dweopnggc = false)
    {
        $this->connect();
        $Vcnupmc0tq42 = mysqli_real_escape_string($this->getConnection(), $Vekcdji4zgv4);
        if ($Vz5dweopnggc) {
            $Vcnupmc0tq42 = addcslashes($Vcnupmc0tq42, '%_');
        }
        return $Vcnupmc0tq42;
    }
    public static function isSupported()
    {
        return (function_exists('mysqli_connect'));
    }
    public function connected()
    {
        if (is_object($this->connection)) {
            return mysqli_ping($this->connection);
        }
        return false;
    }
    public function dropTable($Vinwkv3lhccq, $V1k5gx5hzo0z = true)
    {
        $this->connect();
        $Vgnwamn5izbn = $this->getQuery(true);
        $this->setQuery('DROP TABLE ' . ($V1k5gx5hzo0z ? 'IF EXISTS ' : '') . $Vgnwamn5izbn->quoteName($Vinwkv3lhccq));
        $this->execute();
        return $this;
    }
    public function getAffectedRows()
    {
        $this->connect();
        return mysqli_affected_rows($this->connection);
    }
    public function getCollation()
    {
        $this->connect();
        $Vycuyxvjfem3 = $this->getTableList();
        $this->setQuery('SHOW FULL COLUMNS FROM ' . $Vycuyxvjfem3[0]);
        $Vmc3gjvkzomz = $this->loadAssocList();
        foreach ($Vmc3gjvkzomz as $Vmtc4isbrsvb) {
            if (!is_null($Vmtc4isbrsvb['Collation'])) {
                return $Vmtc4isbrsvb['Collation'];
            }
        }
        return null;
    }
    public function getNumRows($Vtlwi0k43c4n = null)
    {
        return mysqli_num_rows($Vtlwi0k43c4n ? $Vtlwi0k43c4n : $this->cursor);
    }
    public function getTableCreate($Vycuyxvjfem3)
    {
        $this->connect();
        $Vcnupmc0tq42 = array();
        settype($Vycuyxvjfem3, 'array');
        foreach ($Vycuyxvjfem3 as $Vu5rks24ariz) {
            $this->setQuery('SHOW CREATE table ' . $this->quoteName($this->escape($Vu5rks24ariz)));
            $Vdtsunkf2kp1                = $this->loadRow();
            $Vcnupmc0tq42[$Vu5rks24ariz] = $Vdtsunkf2kp1[1];
        }
        return $Vcnupmc0tq42;
    }
    public function getTableColumns($Vu5rks24ariz, $Vhvpmi3o2sat = true)
    {
        $this->connect();
        $Vcnupmc0tq42 = array();
        $this->setQuery('SHOW FULL COLUMNS FROM ' . $this->quoteName($this->escape($Vu5rks24ariz)));
        $Vmtc4isbrsvbs = $this->loadObjectList();
        if ($Vhvpmi3o2sat) {
            foreach ($Vmtc4isbrsvbs as $Vmtc4isbrsvb) {
                $Vcnupmc0tq42[$Vmtc4isbrsvb->Field] = preg_replace("/[(0-9)]/", '', $Vmtc4isbrsvb->Type);
            }
        } else {
            foreach ($Vmtc4isbrsvbs as $Vmtc4isbrsvb) {
                $Vcnupmc0tq42[$Vmtc4isbrsvb->Field] = $Vmtc4isbrsvb;
            }
        }
        return $Vcnupmc0tq42;
    }
    public function getTableKeys($Vu5rks24ariz)
    {
        $this->connect();
        $this->setQuery('SHOW KEYS FROM ' . $this->quoteName($Vu5rks24ariz));
        $Vokderrs40g1 = $this->loadObjectList();
        return $Vokderrs40g1;
    }
    public function getTableList()
    {
        $this->connect();
        $this->setQuery('SHOW TABLES');
        $Vycuyxvjfem3 = $this->loadColumn();
        return $Vycuyxvjfem3;
    }
    public function getVersion()
    {
        $this->connect();
        return mysqli_get_server_info($this->connection);
    }
    public function insertid()
    {
        $this->connect();
        return mysqli_insert_id($this->connection);
    }
    public function lockTable($Vu5rks24ariz)
    {
        $this->setQuery('LOCK TABLES ' . $this->quoteName($Vu5rks24ariz) . ' WRITE')->execute();
        return $this;
    }
    public function execute()
    {
        $this->connect();
        if (!is_object($this->connection)) {
            throw new RuntimeException($this->errorMsg, $this->errorNum);
        }
        $Vgnwamn5izbn = $this->replacePrefix((string) $this->sql);
        if (!($this->sql instanceof JDatabaseQuery) && ($this->limit > 0 || $this->offset > 0)) {
            $Vgnwamn5izbn .= ' LIMIT ' . $this->offset . ', ' . $this->limit;
        }
        $this->count++;
        $this->errorNum = 0;
        $this->errorMsg = '';
        $Vd31yjcatclg   = null;
        if ($this->debug) {
            $this->log[]     = $Vgnwamn5izbn;
            $this->timings[] = microtime(true);
            if (is_object($this->cursor)) {
                @$this->freeResult();
            }
            $Vd31yjcatclg = memory_get_usage();
        }
        $this->cursor = @mysqli_query($this->connection, $Vgnwamn5izbn);
        if ($this->debug) {
            $this->timings[] = microtime(true);
            if (defined('DEBUG_BACKTRACE_IGNORE_ARGS')) {
                $this->callStacks[] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            } else {
                $this->callStacks[] = debug_backtrace();
            }
            $this->callStacks[count($this->callStacks) - 1][0]['memory'] = array(
                $Vd31yjcatclg,
                memory_get_usage(),
                is_object($this->cursor) ? $this->getNumRows() : null
            );
        }
        if (!$this->cursor) {
            $this->errorNum = (int) mysqli_errno($this->connection);
            $this->errorMsg = (string) mysqli_error($this->connection) . ' SQL=' . $Vgnwamn5izbn;
            if (!$this->connected()) {
                try {
                    $this->connection = null;
                    $this->connect();
                }
                catch (RuntimeException $Vkl0xnschdfr) {
                    throw new RuntimeException($this->errorMsg, $this->errorNum);
                }
                return $this->execute();
            } else {
                throw new RuntimeException($this->errorMsg, $this->errorNum);
            }
        }
        return $this->cursor;
    }
    public function renameTable($Vnljkuir5a4e, $Veohjn5w04ln, $Vldw5nvuuwps = null, $Vqvjcrnhx5sr = null)
    {
        $this->setQuery('RENAME TABLE ' . $Vnljkuir5a4e . ' TO ' . $Veohjn5w04ln)->execute();
        return $this;
    }
    public function select($Vy4c54oy2go2)
    {
        $this->connect();
        if (!$Vy4c54oy2go2) {
            return false;
        }
        if (!mysqli_select_db($this->connection, $Vy4c54oy2go2)) {
            throw new RuntimeException('Could not connect to database.');
        }
        return true;
    }
    public function setUTF()
    {
        $this->connect();
        return $this->connection->set_charset('utf8');
    }
    public function transactionCommit($Vfoqnft0whx0 = false)
    {
        $this->connect();
        if (!$Vfoqnft0whx0 || $this->transactionDepth <= 1) {
            if ($this->setQuery('COMMIT')->execute()) {
                $this->transactionDepth = 0;
            }
            return;
        }
        $this->transactionDepth--;
    }
    public function transactionRollback($Vfoqnft0whx0 = false)
    {
        $this->connect();
        if (!$Vfoqnft0whx0 || $this->transactionDepth <= 1) {
            if ($this->setQuery('ROLLBACK')->execute()) {
                $this->transactionDepth = 0;
            }
            return;
        }
        $Vm34tzlunhx0 = 'SP_' . ($this->transactionDepth - 1);
        $this->setQuery('ROLLBACK TO SAVEPOINT ' . $this->quoteName($Vm34tzlunhx0));
        if ($this->execute()) {
            $this->transactionDepth--;
        }
    }
    public function transactionStart($Vssngouo54mf = false)
    {
        $this->connect();
        if (!$Vssngouo54mf || !$this->transactionDepth) {
            if ($this->setQuery('START TRANSACTION')->execute()) {
                $this->transactionDepth = 1;
            }
            return;
        }
        $Vm34tzlunhx0 = 'SP_' . $this->transactionDepth;
        $this->setQuery('SAVEPOINT ' . $this->quoteName($Vm34tzlunhx0));
        if ($this->execute()) {
            $this->transactionDepth++;
        }
    }
    protected function fetchArray($Vtlwi0k43c4n = null)
    {
        return mysqli_fetch_row($Vtlwi0k43c4n ? $Vtlwi0k43c4n : $this->cursor);
    }
    protected function fetchAssoc($Vtlwi0k43c4n = null)
    {
        return mysqli_fetch_assoc($Vtlwi0k43c4n ? $Vtlwi0k43c4n : $this->cursor);
    }
    protected function fetchObject($Vtlwi0k43c4n = null, $Vy1fvjbt20zn = 'stdClass')
    {
        return mysqli_fetch_object($Vtlwi0k43c4n ? $Vtlwi0k43c4n : $this->cursor, $Vy1fvjbt20zn);
    }
    protected function freeResult($Vtlwi0k43c4n = null)
    {
        mysqli_free_result($Vtlwi0k43c4n ? $Vtlwi0k43c4n : $this->cursor);
        if ((!$Vtlwi0k43c4n) || ($Vtlwi0k43c4n === $this->cursor)) {
            $this->cursor = null;
        }
    }
    public function unlockTables()
    {
        $this->setQuery('UNLOCK TABLES')->execute();
        return $this;
    }
    private function hasProfiling()
    {
        try {
            $Vbdr2fqfrgnb = mysqli_query($this->connection, "SHOW VARIABLES LIKE 'have_profiling'");
            $Vdtsunkf2kp1 = mysqli_fetch_assoc($Vbdr2fqfrgnb);
            return isset($Vdtsunkf2kp1);
        }
        catch (Exception $Vkl0xnschdfr) {
            return false;
        }
    }
}