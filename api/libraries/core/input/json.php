<?php
 defined('LIBS_PATH') or die; class JInputJSON extends JInput { private $_raw; public function __construct(array $source = null, array $options = array()) { if (isset($options['filter'])) { $this->filter = $options['filter']; } else { $this->filter = JFilterInput::getInstance(); } if (is_null($source)) { $this->_raw = file_get_contents('php://input'); $this->data = json_decode($this->_raw, true); } else { $this->data = & $source; } $this->options = $options; } public function getRaw() { return $this->_raw; } }