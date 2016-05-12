<?php
 defined('LIBS_PATH') or die; abstract class JControllerBase { public $app = null; protected $task; protected $taskMap; protected $db = null; protected $data = array(); public function __construct($app) { $this->app = $app; $this->data = &$_REQUEST; $this->taskMap = array(); $xMethods = get_class_methods('JControllerBase'); $r = new ReflectionClass($this); $rMethods = $r->getMethods(ReflectionMethod::IS_PUBLIC); foreach ($rMethods as $rMethod) { $mName = $rMethod->getName(); if (!in_array($mName, $xMethods) || $mName == 'display') { $this->methods[] = strtolower($mName); $this->taskMap[strtolower($mName)] = $mName; } } } public function execute($task = 'display') { $this->task = $task; $task = strtolower($task); if (isset($this->taskMap[$task])) { $doTask = $this->taskMap[$task]; } elseif (isset($this->taskMap['__default'])) { $doTask = $this->taskMap['__default']; } else { throw new Exception(sprintf('Task `%s` not found', $task), 404); } $this->doTask = $doTask; return $this->$doTask(); } public function get_detail_id() { $path = $this->app->uri->getPath(); if (empty($path)) return 0; $rest = explode('/', $path); if (empty($rest)) return 0; $rest = $rest[count($rest) - 1]; $rest = explode('-', str_replace('.html', '', $rest)); if (empty($rest)) return 0; return $rest[count($rest) - 1]; } }