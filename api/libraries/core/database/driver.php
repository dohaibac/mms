<?php
 defined('LIBS_PATH') or die; interface JDatabaseInterface { public static function isSupported(); } abstract class JDatabaseDriver extends JDatabase implements JDatabaseInterface { private $_database; public $name; protected $connection; protected $count = 0; protected $cursor; protected $debug = false; protected $limit = 0; protected $log = array(); protected $timings = array(); protected $callStacks = array(); protected $nameQuote; protected $nullDate; protected $offset = 0; protected $options; protected $sql; protected $tablePrefix; protected $utf = true; protected $errorNum = 0; protected $errorMsg; protected static $instances = array(); protected static $dbMinimum; protected $transactionDepth = 0; protected $disconnectHandlers = array(); public static function getConnectors() { $connectors = array(); $iterator = new DirectoryIterator(__DIR__ . '/driver'); foreach ($iterator as $file) { $fileName = $file->getFilename(); if (!$file->isFile() || substr($fileName, strrpos($fileName, '.') + 1) != 'php') { continue; } $class = str_ireplace('.php', '', 'JDatabaseDriver' . ucfirst(trim($fileName))); if (!class_exists($class)) { continue; } if ($class::isSupported()) { $connectors[] = str_ireplace('.php', '', $fileName); } } return $connectors; } public static function getInstance($options = array()) { $options['driver'] = (isset($options['driver'])) ? preg_replace('/[^A-Z0-9_\.-]/i', '', $options['driver']) : 'mysqli'; $options['database'] = (isset($options['database'])) ? $options['database'] : null; $options['select'] = (isset($options['select'])) ? $options['select'] : true; $signature = md5(serialize($options)); if (empty(self::$instances[$signature])) { $class = 'JDatabaseDriver' . ucfirst(strtolower($options['driver'])); if (!class_exists($class)) { throw new RuntimeException(sprintf('Unable to load Database Driver: %s', $options['driver'])); } try { $instance = new $class($options); } catch (RuntimeException $e) { throw new RuntimeException(sprintf('Unable to connect to the Database: %s', $e->getMessage())); } self::$instances[$signature] = $instance; } return self::$instances[$signature]; } public static function splitSql($sql) { $start = 0; $open = false; $char = ''; $end = strlen($sql); $queries = array(); for ($i = 0; $i < $end; $i++) { $current = substr($sql, $i, 1); if (($current == '"' || $current == '\'')) { $n = 2; while (substr($sql, $i - $n + 1, 1) == '\\' && $n < $i) { $n++; } if ($n % 2 == 0) { if ($open) { if ($current == $char) { $open = false; $char = ''; } } else { $open = true; $char = $current; } } } if (($current == ';' && !$open) || $i == $end - 1) { $queries[] = substr($sql, $start, ($i - $start + 1)); $start = $i + 1; } } return $queries; } public function __call($method, $args) { if (empty($args)) { return; } switch ($method) { case 'q': return $this->quote($args[0], isset($args[1]) ? $args[1] : true); break; case 'qn': return $this->quoteName($args[0], isset($args[1]) ? $args[1] : null); break; } } public function __construct($options) { $this->_database = (isset($options['database'])) ? $options['database'] : ''; $this->tablePrefix = (isset($options['prefix'])) ? $options['prefix'] : 'jos_'; $this->count = 0; $this->errorNum = 0; $this->log = array(); $this->options = $options; } public function alterDbCharacterSet($dbName) { if (is_null($dbName)) { throw new RuntimeException('Database name must not be null.'); } $this->setQuery($this->getAlterDbCharacterSet($dbName)); return $this->execute(); } abstract public function connect(); abstract public function connected(); public function createDatabase($options, $utf = true) { if (is_null($options)) { throw new RuntimeException('$options object must not be null.'); } elseif (empty($options->db_name)) { throw new RuntimeException('$options object must have db_name set.'); } elseif (empty($options->db_user)) { throw new RuntimeException('$options object must have db_user set.'); } $this->setQuery($this->getCreateDatabaseQuery($options, $utf)); return $this->execute(); } abstract public function disconnect(); public function addDisconnectHandler($callable) { $this->disconnectHandlers[] = $callable; } public abstract function dropTable($table, $ifExists = true); abstract public function escape($text, $extra = false); abstract protected function fetchArray($cursor = null); abstract protected function fetchAssoc($cursor = null); abstract protected function fetchObject($cursor = null, $class = 'stdClass'); abstract protected function freeResult($cursor = null); abstract public function getAffectedRows(); protected function getAlterDbCharacterSet($dbName) { return 'ALTER DATABASE ' . $this->quoteName($dbName) . ' CHARACTER SET `utf8`'; } protected function getCreateDatabaseQuery($options, $utf) { if ($utf) { return 'CREATE DATABASE ' . $this->quoteName($options->db_name) . ' CHARACTER SET `utf8`'; } return 'CREATE DATABASE ' . $this->quoteName($options->db_name); } abstract public function getCollation(); public function getConnection() { return $this->connection; } public function getCount() { return $this->count; } protected function getDatabase() { return $this->_database; } public function getDateFormat() { return 'Y-m-d H:i:s'; } public function getLog() { return $this->log; } public function getTimings() { return $this->timings; } public function getCallStacks() { return $this->callStacks; } public function getMinimum() { return static::$dbMinimum; } public function getNullDate() { return $this->nullDate; } abstract public function getNumRows($cursor = null); public function getPrefix() { return $this->tablePrefix; } public function getExporter() { $class = 'JDatabaseExporter' . ucfirst($this->name); if (!class_exists($class)) { throw new RuntimeException('Database Exporter not found.'); } $o = new $class; $o->setDbo($this); return $o; } public function getImporter() { $class = 'JDatabaseImporter' . ucfirst($this->name); if (!class_exists($class)) { throw new RuntimeException('Database Importer not found'); } $o = new $class; $o->setDbo($this); return $o; } public function getQuery($new = false) { if ($new) { $class = 'JDatabaseQuery' . ucfirst($this->name); if (!class_exists($class)) { throw new RuntimeException('Database Query Class not found.'); } return new $class($this); } else { return $this->sql; } } public function getIterator($column = null, $class = 'stdClass') { $iteratorClass = 'JDatabaseIterator' . ucfirst($this->name); if (!class_exists($iteratorClass)) { throw new RuntimeException(sprintf('class *%s* is not defined', $iteratorClass)); } return new $iteratorClass($this->execute(), $column, $class); } abstract public function getTableColumns($table, $typeOnly = true); abstract public function getTableCreate($tables); abstract public function getTableKeys($tables); abstract public function getTableList(); public function getUTFSupport() { return $this->hasUTFSupport(); } public function hasUTFSupport() { return $this->utf; } abstract public function getVersion(); abstract public function insertid(); public function insertObject($table, &$object, $key = null) { $fields = array(); $values = array(); foreach (get_object_vars($object) as $k => $v) { if (is_array($v) or is_object($v) or $v === null) { continue; } if ($k[0] == '_') { continue; } $fields[] = $this->quoteName($k); $values[] = $this->quote($v); } $query = $this->getQuery(true) ->insert($this->quoteName($table)) ->columns($fields) ->values(implode(',', $values)); $this->setQuery($query); if (!$this->execute()) { return false; } $id = $this->insertid(); if ($key && $id && is_string($key)) { $object->$key = $id; } return true; } public function isMinimumVersion() { return version_compare($this->getVersion(), static::$dbMinimum) >= 0; } public function loadAssoc() { $this->connect(); $ret = null; if (!($cursor = $this->execute())) { return null; } if ($array = $this->fetchAssoc($cursor)) { $ret = $array; } $this->freeResult($cursor); return $ret; } public function loadAssocList($key = null, $column = null) { $this->connect(); $array = array(); if (!($cursor = $this->execute())) { return null; } while ($row = $this->fetchAssoc($cursor)) { $value = ($column) ? (isset($row[$column]) ? $row[$column] : $row) : $row; if ($key) { $array[$row[$key]] = $value; } else { $array[] = $value; } } $this->freeResult($cursor); return $array; } public function loadColumn($offset = 0) { $this->connect(); $array = array(); if (!($cursor = $this->execute())) { return null; } while ($row = $this->fetchArray($cursor)) { $array[] = $row[$offset]; } $this->freeResult($cursor); return $array; } public function loadNextObject($class = 'stdClass') { $this->connect(); static $cursor = null; if ( is_null($cursor) ) { if (!($cursor = $this->execute())) { return $this->errorNum ? null : false; } } if ($row = $this->fetchObject($cursor, $class)) { return $row; } $this->freeResult($cursor); $cursor = null; return false; } public function loadNextRow() { $this->connect(); static $cursor = null; if ( is_null($cursor) ) { if (!($cursor = $this->execute())) { return $this->errorNum ? null : false; } } if ($row = $this->fetchArray($cursor)) { return $row; } $this->freeResult($cursor); $cursor = null; return false; } public function loadObject($class = 'stdClass') { $this->connect(); $ret = null; if (!($cursor = $this->execute())) { return null; } if ($object = $this->fetchObject($cursor, $class)) { $ret = $object; } $this->freeResult($cursor); return $ret; } public function loadObjectList($key = '', $class = 'stdClass') { $this->connect(); $array = array(); if (!($cursor = $this->execute())) { return null; } while ($row = $this->fetchObject($cursor, $class)) { if ($key) { $array[$row->$key] = $row; } else { $array[] = $row; } } $this->freeResult($cursor); return $array; } public function loadResult() { $this->connect(); $ret = null; if (!($cursor = $this->execute())) { return null; } if ($row = $this->fetchArray($cursor)) { $ret = $row[0]; } $this->freeResult($cursor); return $ret; } public function loadRow() { $this->connect(); $ret = null; if (!($cursor = $this->execute())) { return null; } if ($row = $this->fetchArray($cursor)) { $ret = $row; } $this->freeResult($cursor); return $ret; } public function loadRowList($key = null) { $this->connect(); $array = array(); if (!($cursor = $this->execute())) { return null; } while ($row = $this->fetchArray($cursor)) { if ($key !== null) { $array[$row[$key]] = $row; } else { $array[] = $row; } } $this->freeResult($cursor); return $array; } public abstract function lockTable($tableName); public function quote($text, $escape = true) { if (is_array($text)) { foreach ($text as $k => $v) { $text[$k] = $this->quote($v, $escape); } return $text; } else { return '\'' . ($escape ? $this->escape($text) : $text) . '\''; } } public function quoteName($name, $as = null) { if (is_string($name)) { $quotedName = $this->quoteNameStr(explode('.', $name)); $quotedAs = ''; if (!is_null($as)) { settype($as, 'array'); $quotedAs .= ' AS ' . $this->quoteNameStr($as); } return $quotedName . $quotedAs; } else { $fin = array(); if (is_null($as)) { foreach ($name as $str) { $fin[] = $this->quoteName($str); } } elseif (is_array($name) && (count($name) == count($as))) { $count = count($name); for ($i = 0; $i < $count; $i++) { $fin[] = $this->quoteName($name[$i], $as[$i]); } } return $fin; } } protected function quoteNameStr($strArr) { $parts = array(); $q = $this->nameQuote; foreach ($strArr as $part) { if (is_null($part)) { continue; } if (strlen($q) == 1) { $parts[] = $q . $part . $q; } else { $parts[] = $q{0} . $part . $q{1}; } } return implode('.', $parts); } public function replacePrefix($sql, $prefix = '#__') { $startPos = 0; $literal = ''; $sql = trim($sql); $n = strlen($sql); while ($startPos < $n) { $ip = strpos($sql, $prefix, $startPos); if ($ip === false) { break; } $j = strpos($sql, "'", $startPos); $k = strpos($sql, '"', $startPos); if (($k !== false) && (($k < $j) || ($j === false))) { $quoteChar = '"'; $j = $k; } else { $quoteChar = "'"; } if ($j === false) { $j = $n; } $literal .= str_replace($prefix, $this->tablePrefix, substr($sql, $startPos, $j - $startPos)); $startPos = $j; $j = $startPos + 1; if ($j >= $n) { break; } while (true) { $k = strpos($sql, $quoteChar, $j); $escaped = false; if ($k === false) { break; } $l = $k - 1; while ($l >= 0 && $sql{$l} == '\\') { $l--; $escaped = !$escaped; } if ($escaped) { $j = $k + 1; continue; } break; } if ($k === false) { break; } $literal .= substr($sql, $startPos, $k - $startPos + 1); $startPos = $k + 1; } if ($startPos < $n) { $literal .= substr($sql, $startPos, $n - $startPos); } return $literal; } public abstract function renameTable($oldTable, $newTable, $backup = null, $prefix = null); abstract public function select($database); public function setDebug($level) { $previous = $this->debug; $this->debug = (bool) $level; return $previous; } public function setQuery($query, $offset = 0, $limit = 0) { $this->sql = $query; if ($query instanceof JDatabaseQueryLimitable) { $query->setLimit($limit, $offset); } else { $this->limit = (int) max(0, $limit); $this->offset = (int) max(0, $offset); } return $this; } abstract public function setUTF(); abstract public function transactionCommit($toSavepoint = false); abstract public function transactionRollback($toSavepoint = false); abstract public function transactionStart($asSavepoint = false); public function truncateTable($table) { $this->setQuery('TRUNCATE TABLE ' . $this->quoteName($table)); $this->execute(); } public function updateObject($table, &$object, $key, $nulls = false) { $fields = array(); $where = array(); if (is_string($key)) { $key = array($key); } if (is_object($key)) { $key = (array) $key; } $statement = 'UPDATE ' . $this->quoteName($table) . ' SET %s WHERE %s'; foreach (get_object_vars($object) as $k => $v) { if (is_array($v) or is_object($v) or $k[0] == '_') { continue; } if (in_array($k, $key)) { $where[] = $this->quoteName($k) . '=' . $this->quote($v); continue; } if ($v === null) { if ($nulls) { $val = 'NULL'; } else { continue; } } else { $val = $this->quote($v); } $fields[] = $this->quoteName($k) . '=' . $val; } if (empty($fields)) { return true; } $this->setQuery(sprintf($statement, implode(",", $fields), implode(' AND ', $where))); return $this->execute(); } abstract public function execute(); public abstract function unlockTables(); }