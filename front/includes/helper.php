<?php

defined('BASEPATH') or die;

/**
 * Application helper class.
 * 
 *
 * @package     root.includes
 * @subpackage  Application
 * @since       1.5
 */
class JApplicationHelper
{
  /**
   * Detect urls and get page.
   *
   * @return  string  The component to access.
   *
   * @since   2.0
   */
  public static function findOption() {
    $app = JBase::getApplication(__APP_NAME__);
    
    $routerConf = $app->routerConf;
    
    $path = $app->uri->getPath();
    
    $path = ltrim($path, '/');
    
    $controller = '';
    $action = '';
    
    // if path is empty, it is index page
    foreach ($routerConf as $router=>$val) {
      @preg_match($router, trim($path, '!'), $matches, PREG_OFFSET_CAPTURE);
      if ($matches) {
        $app->currentPage = self::get_current_page($val['page']);
        $app->currentPage['matches'] = $matches;
        if (isset($val['controller'])) {
          $app->currentPage['controller'] = $val['controller'];
        }
        if (isset($val['action'])) {
          $app->currentPage['action'] = $val['action'];
        }
        break;
      }
    }
    
    if (isset($app->currentPage['controller'])) {
      $controller = $app->currentPage['controller'];
    }
    if (isset($app->currentPage['action'])) {
      $action = $app->currentPage['action'];
    }
    
    if (!empty($controller)) {
      $app->options = array(__ctrl__ => $controller, __task__=>$action);
    }
    
  }
  
  /***
   * Lay danh sach modules theo vi tri
   * 
   * $pageName : current page
   * $pos_name: ten vi tri
   * */
  public static function get_list_modules($pos_name) {
    
    $app = JBase::getApplication(__APP_NAME__);
    
    $currentPage = $app->currentPage;
    
    if (isset($currentPage['modules']) && isset($currentPage['modules'][$pos_name])) {
      return $currentPage['modules'][$pos_name];
    }
    
    return array();
  }

  public static function get_current_page ($page) {
    $app = JBase::getApplication(__APP_NAME__);
    $pageConf = $app->pageConf;
    
    if (isset($pageConf[$page])) {
      return $pageConf[$page];
    }
  }
  public static function get_theme_page_name () {
    $app = JBase::getApplication(__APP_NAME__);
    
    if (empty($app->currentPage)) {
      return 'index';
    }
    
    if (isset($app->currentPage['theme_page_name'])) {
      return $app->currentPage['theme_page_name'];
    }
    
    return 'index';
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
