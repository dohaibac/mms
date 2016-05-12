<?php
defined('BASEPATH') or die;

/**
 * Administrator Application helper class.
 * Provide many supporting API functions.
 *
 * @package     includes
 * @subpackage  Application
 * @since       1.5
 */
class JAdministratorHelper
{
  /**
   * Return the application option string [main component].
   *
   * @return  string  The component to access.
   *
   * @since   1.5
   */
  public static function findOption()
  {
    $app = JBase::getApplication(__APP_NAME__);
    
    $map = array();
    
    global $routerMap;
    
    if (!empty($routerMap)) {
      $map = $app->router->map;
    }
    
    if (!empty($map)) {
      $opt = $map['controller'];
      $task = $map['action'];
    } else {
      $opt = $app->uri->getVar(__ctrl__);
      $task = $app->uri->getVar(__task__);
    }
    
    if (empty($opt)) {
      $opt   = 'cpanel';
    }
    
    return array(__ctrl__ => $opt, __task__=>$task); 
  }
}

function generate_signal($method, $secret, $request_path, $expires, $params=array(), $request_body="") {
  $to_sign = $method . $secret . $request_path . $expires;
  
  if (!empty($params)) {
    $keys = sortKeys($params);
    foreach ($keys as $key) {
      $to_sign .= $key . "=" . $params[$key];
    }
  }
  
  if (!empty($request_body)) {
    $to_sign .= $request_body;
  }
  
  $hash = hash("sha256", $to_sign, true);
  $base = base64_encode($hash);
  $base = substr($base, 0, 43);
  $base = urlencode($base);
  
  return $base;
}

function sortKeys ($array) {
  $keys = array();$ind=0;
  foreach ($array as $key => $val) {
    $keys[$ind++]=$key;
  }
  sort($keys);
  return $keys;
}

function add_zero_in_single_number($number) {
  if (strlen($number) == 1) return '0'.$number;
  return $number;
}