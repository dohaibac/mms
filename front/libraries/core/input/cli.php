<?php
 defined('JPATH_PLATFORM') or die; class JInputCli extends JInput { public $executable; public $args = array(); public function __construct(array $source = null, array $options = array()) { if (isset($options['filter'])) { $this->filter = $options['filter']; } else { $this->filter = JFilterInput::getInstance(); } $this->parseArguments(); $this->options = $options; } public function serialize() { $this->loadAllInputs(); $inputs = $this->inputs; unset($inputs['env']); unset($inputs['server']); return serialize(array($this->executable, $this->args, $this->options, $this->data, $inputs)); } public function unserialize($input) { list($this->executable, $this->args, $this->options, $this->data, $this->inputs) = unserialize($input); if (isset($this->options['filter'])) { $this->filter = $this->options['filter']; } else { $this->filter = JFilterInput::getInstance(); } } protected function parseArguments() { $argv = $_SERVER['argv']; $this->executable = array_shift($argv); $out = array(); for ($i = 0, $j = count($argv); $i < $j; $i++) { $arg = $argv[$i]; if (substr($arg, 0, 2) === '--') { $eqPos = strpos($arg, '='); if ($eqPos === false) { $key = substr($arg, 2); if ($i + 1 < $j && $argv[$i + 1][0] !== '-') { $value = $argv[$i + 1]; $i++; } else { $value = isset($out[$key]) ? $out[$key] : true; } $out[$key] = $value; } else { $key = substr($arg, 2, $eqPos - 2); $value = substr($arg, $eqPos + 1); $out[$key] = $value; } } elseif (substr($arg, 0, 1) === '-') { if (substr($arg, 2, 1) === '=') { $key = substr($arg, 1, 1); $value = substr($arg, 3); $out[$key] = $value; } else { $chars = str_split(substr($arg, 1)); foreach ($chars as $char) { $key = $char; $value = isset($out[$key]) ? $out[$key] : true; $out[$key] = $value; } if ((count($chars) === 1) && ($i + 1 < $j) && ($argv[$i + 1][0] !== '-')) { $out[$key] = $argv[$i + 1]; $i++; } } } else { $this->args[] = $arg; } } $this->data = $out; } }