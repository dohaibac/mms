<?php
defined('LIBS_PATH') or die;

class JApplicationApi extends JBase
{
  public $options = null;
  
  public function __construct()
  {
    $this->router   = new JRouter($this);
    parent::__construct();
    $this->document = new JDocumentAdmin(array(), __APP_NAME__);
    
    $this->init();
    $this->set_app_cookie();
  }
  
  public function execute()
  {
    $this->options = JAdministratorHelper::findOption();
    
    $contents      = JComponentHelper::renderComponent('com_' . $this->options[__ctrl__]);
    echo $contents;
  }
  
  function init() {
    require_once PATH_LIBRARIES .'/core/config/appConfig.php';
    
    $this->appConf = JAppConf::getInstance();
    
    $this->appConf->domain  = $this->uri->getHost();
    $this->appConf->ctrl  = __ctrl__;
    $this->appConf->task  = __task__;
    
    $this->base_url   = $this->appConf->base_url;
  }
  
  public function getController($name, $base = '')
  {
   
    $class = ucfirst($name) . 'Controller';
    
    if (!class_exists($class)) {
      $path = $base . '/controller.php';
      if (file_exists($path)) {
        require_once $path;
      } else {
          throw new InvalidArgumentException(sprintf('invalid controller `%s`', $name));
      }
    }
    
    if (!class_exists($class)) {
      throw new RuntimeException(sprintf('Unable to locate controller `%s`.', $class), 404);
    }
    
    $controller = new $class($this);
    
    return $controller;
  }
  
  public function set_app_cookie() {
    ini_set('session.cookie_domain', $this->appConf->cookie_domain);
    
    ini_set('session.name', 'am5sess');
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.gc_maxlifetime', 60 * 60 * 24 * 365);
    ini_set('session.cookie_lifetime', 0);
    
    session_cache_limiter('none');
    
    ini_set('expose_php', '0');
    
    if ($this->appConf->debug_mode == 1) {
      ini_set('display_errors', '1');
      ini_set('error_reporting', E_ALL);
    }
    else {
      ini_set('display_errors', '0');
    }
  }
  
  /***
   * Write log file
   * 
   * */
  public function write_log($message) {
    $logfile = $this->appConf->log_file;
    
    $logfile = $logfile . date('Y-m-d') . '.log';
    error_log(date('Y-m-d h:m:s'). ' - ' . $message . PHP_EOL, 3, $logfile);
  }
}