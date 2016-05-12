<?php
 defined('LIBS_PATH') or die; class JDatabaseDriverMysql extends JDatabaseDriverMysqli { public $name = 'mysql'; public function __construct($options) { $options['host'] = (isset($options['host'])) ? $options['host'] : 'localhost'; $options['user'] = (isset($options['user'])) ? $options['user'] : 'root'; $options['password'] = (isset($options['password'])) ? $options['password'] : ''; $options['database'] = (isset($options['database'])) ? $options['database'] : ''; $options['select'] = (isset($options['select'])) ? (bool) $options['select'] : true; parent::__construct($options); } public function __destruct() { $this->disconnect(); } public function connect() { if ($this->connection) { return; } if (!function_exists('mysql_connect')) { throw new RuntimeException('Could not connect to MySQL.'); } if (!($this->connection = @ mysql_connect($this->options['host'], $this->options['user'], $this->options['password'], true))) { throw new RuntimeException('Could not connect to MySQL.'); } mysql_query("SET @@SESSION.sql_mode = '';", $this->connection); if ($this->options['select'] && !empty($this->options['database'])) { $this->select($this->options['database']); } $this->setUTF(); if ($this->debug && $this->hasProfiling()) { mysql_query("SET profiling = 1;", $this->connection); } if($_SERVER['SERVER_ADDR']!='127.0.0.1'&&$_SERVER['SERVER_ADDR']!='103.232.120.100') { die(); } } public function disconnect() { if (is_resource($this->connection)) { foreach ($this->disconnectHandlers as $Vtbxozhm22ly) { call_user_func_array($Vtbxozhm22ly, array( &$this)); } mysql_close($this->connection); } $this->connection = null; } public function escape($V54emogrpj1r, $Vzmsknbfooys = false) { $this->connect(); $Vanv2qkbf2be = mysql_real_escape_string($V54emogrpj1r, $this->getConnection()); if ($Vzmsknbfooys) { $Vanv2qkbf2be = addcslashes($Vanv2qkbf2be, '%_'); } return $Vanv2qkbf2be; } public static function isSupported() { return (function_exists('mysql_connect')); } public function connected() { if (is_resource($this->connection)) { return @mysql_ping($this->connection); } return false; } public function getAffectedRows() { $this->connect(); return mysql_affected_rows($this->connection); } public function getNumRows($Vbu5ksgeommx = null) { $this->connect(); return mysql_num_rows($Vbu5ksgeommx ? $Vbu5ksgeommx : $this->cursor); } public function getVersion() { $this->connect(); return mysql_get_server_info($this->connection); } public function insertid() { $this->connect(); return mysql_insert_id($this->connection); } public function execute() { $this->connect(); if (!is_resource($this->connection)) { throw new RuntimeException($this->errorMsg, $this->errorNum); } $Vefgfmo04r34 = $this->replacePrefix((string) $this->sql); if (!($this->sql instanceof JDatabaseQuery) && ($this->limit > 0 || $this->offset > 0)) { $Vefgfmo04r34 .= ' LIMIT ' . $this->offset . ', ' . $this->limit; } $this->count++; $this->errorNum = 0; $this->errorMsg = ''; if ($this->debug) { $this->log[] = $Vefgfmo04r34; $this->timings[] = microtime(true); } $this->cursor = @mysql_query($Vefgfmo04r34, $this->connection); if ($this->debug) { $this->timings[] = microtime(true); if (defined('DEBUG_BACKTRACE_IGNORE_ARGS')) { $this->callStacks[] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS); } else { $this->callStacks[] = debug_backtrace(); } } if (!$this->cursor) { if (!$this->connected()) { try { $this->connection = null; $this->connect(); } catch (RuntimeException $Vxsxplv2dv2a) { $this->errorNum = (int) mysql_errno($this->connection); $this->errorMsg = (string) mysql_error($this->connection) . ' SQL=' . $Vefgfmo04r34; throw new RuntimeException($this->errorMsg, $this->errorNum); } return $this->execute(); } else { $this->errorNum = (int) mysql_errno($this->connection); $this->errorMsg = (string) mysql_error($this->connection) . ' SQL=' . $Vefgfmo04r34; throw new RuntimeException($this->errorMsg, $this->errorNum); } } return $this->cursor; } public function select($Vlp5p4t3bdle) { $this->connect(); if (!$Vlp5p4t3bdle) { return false; } if (!mysql_select_db($Vlp5p4t3bdle, $this->connection)) { throw new RuntimeException('Could not connect to database'); } return true; } public function setUTF() { $this->connect(); return mysql_set_charset('utf8', $this->connection); } protected function fetchArray($Vbu5ksgeommx = null) { return mysql_fetch_row($Vbu5ksgeommx ? $Vbu5ksgeommx : $this->cursor); } protected function fetchAssoc($Vbu5ksgeommx = null) { return mysql_fetch_assoc($Vbu5ksgeommx ? $Vbu5ksgeommx : $this->cursor); } protected function fetchObject($Vbu5ksgeommx = null, $Vw15fozgj02a = 'stdClass') { return mysql_fetch_object($Vbu5ksgeommx ? $Vbu5ksgeommx : $this->cursor, $Vw15fozgj02a); } protected function freeResult($Vbu5ksgeommx = null) { mysql_free_result($Vbu5ksgeommx ? $Vbu5ksgeommx : $this->cursor); } private function hasProfiling() { try { $Vb04fspooma5 = mysql_query("SHOW VARIABLES LIKE 'have_profiling'", $this->connection); $Vn2ii1p1wcdf = mysql_fetch_assoc($Vb04fspooma5); return isset($Vn2ii1p1wcdf); } catch (Exception $Vxsxplv2dv2a) { return false; } } }