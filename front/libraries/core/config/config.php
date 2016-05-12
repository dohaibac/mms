<?php
defined('LIBS_PATH') or die;
class JConfig
{
  public static function get($name, $default = '')
  {
    if (function_exists('apache_getenv')) {
        $value = apache_getenv($name);
    } else {
        $value = getenv($name);
    }
    return empty($value) ? $default : $value;
  }
}