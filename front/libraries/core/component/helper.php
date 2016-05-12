<?php
defined('BASEPATH') or die;
class JComponentHelper
{
    protected static $components = array();
    public static function getComponent($option, $strict = false)
    {
        $result = static::$components[$option];
        return $result;
    }
    public static function renderComponent($option, $params = array())
    {
        $option = preg_replace('/[^A-Z0-9_\.-]/i', '', $option);
        
        if (!defined('JPATH_COMPONENT')) {
          define('JPATH_COMPONENT', BASEPATH . '/components');
        }
        
        $path     = JPATH_COMPONENT . '/' . $option;
        
        return static::executeComponent($path);
    }
    protected static function executeComponent($path)
    {
      $app = JBase::getApplication(__APP_NAME__);

      $controller = $app->getController($app->options[__ctrl__],  $path);
      
      ob_start();
      
      $controller->execute($app->options[__task__]);
      $contents = ob_get_clean();
      
      @ob_end_clean();
      
      return $contents;
    }
}