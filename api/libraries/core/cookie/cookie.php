<?php
 defined('LIBS_PATH') or die; class JCookie extends JInput { protected $data = array(); public function __construct(array $source = null, array $options = array()) { if (isset($options['filter'])) { $this->filter = $options['filter']; } else { $this->filter = JFilterInput::getInstance(); } $this->data = & $_COOKIE; $this->options = $options; } public function set($name, $value, $expire = 0, $path = '', $domain = '', $secure = false, $httpOnly = false) { setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly); $this->data[$name] = $value; } }