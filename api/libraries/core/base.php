<?php

defined('LIBS_PATH') or die;

class JBase
{
  public static $cache = null;
  public static $session = null;
  public static $language = null;
  public static $db = null;
  public static $mailer = null;
  public $smarty = null;
  public $base_url = null;
  
  public $appConf = null;
  
  public $docs = null;
  public $router = null;
  public $uri = null;
   
  public $client = null;
  public static $application = null;
  protected static $instance;
  protected $document = null;
  
  public function __construct()
  {
      $this->uri     = JUri::getInstance();
      
      $this->client  = new JApplicationWebClient();
      
      $uri   = $this->uri->getPath();
      
      if (strpos($uri, '/index.php') !== false) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        header("Status: 404 Not Found");
        $_SERVER['REDIRECT_STATUS'] = 404;
        include BASEPATH . '/errors.php';
        exit;
      }
  }
  
  public static function getInstance()
  {
      if (!is_object(self::$instance)) {
          self::$instance = new JBase();
      }
      return self::$instance;
  }
  
  public static function getApplication($name = null)
  {
      if (empty(static::$application[$name])) {
          $className = 'JApplication' . ucfirst($name);
          if (!class_exists($className)) {
              throw new RuntimeException('APPLICATION_ERROR_APPLICATION_LOAD', 500);
          }
          static::$application[$name] = new $className;
      }
      return static::$application[$name];
  }
  
  public function loadView($Vvh3ydqrunu1 = '', $Vjtpsnimi2t5 = '.php')
  {
      if ($Vvh3ydqrunu1 == '') {
          return;
      }
      $Vvh3ydqrunu1 = '.' . '/views/' . $Vvh3ydqrunu1 . $Vjtpsnimi2t5;
      $this->smarty->display($Vvh3ydqrunu1);
  }
  
  /***
   * Assign data de su dung tren view
   * 
   * */
  public function setVars($name = null, $data = array())
  {
      if ($name == null) {
          $this->smarty->assign($data);
      } else {
          $this->smarty->assign($name, $data);
      }
      return $this;
  }
  
  public function includes($file = '')
  {
      if (empty($file))
        return;
      if (file_exists($file)) {
          require_once($file);
      }
  }
  public function loadHelper($name = '')
  {
      if (empty($name))
          return;
      $V3fo5n1pqffn = explode('_', $name);
      $Vvpqnhvu15nc = '';
      foreach ($V3fo5n1pqffn as $V1xafvnmfkes) {
          $Vvpqnhvu15nc = $Vvpqnhvu15nc . ucfirst($V1xafvnmfkes);
      }
      if (empty($Vvpqnhvu15nc))
          return;
      if (!class_exists($Vvpqnhvu15nc)) {
          require_once(PATH_LIBRARIES . '/helper/' . $name . '.php');
      }
  }
  public static function getSession(array $Vrdmrcu5s000 = array())
  {
      if (!self::$session) {
          self::$session = self::createSession($Vrdmrcu5s000);
      }
      return self::$session;
  }
  public static function getUser($Vaifjss0bg42 = null)
  {
      return JUser::getInstance();
  }
  public static function getDbo()
  {
    if (!self::$db) {
        self::$db = self::createDbo();
    }
    return self::$db;
  }
   
  protected function getRouter()
  {
    return new JRouter($this);
  }
  
  protected static function createDbo($host = '', $user = '', $pass = '', $db_name = '', $prefix = '', $db_driver = '')
  {
      $appConf = JAppConf::getInstance();
      
      $host = empty($host) ? $appConf->db_host : $host;
      $user = empty($user) ? $appConf->db_user : $user;
      $pass = empty($pass) ? $appConf->db_password : $pass;
      $db_name = empty($db_name) ? $appConf->db_name : $db_name;
      $prefix = empty($prefix) ? $appConf->db_prefix : $prefix;
      $db_driver = empty($db_driver) ? $appConf->db_driver : $db_driver;
      
      $driver = array(
          'driver' => $db_driver,
          'host' => $host,
          'user' => $user,
          'password' => $pass,
          'database' => $db_name,
          'prefix' => $prefix
      );
      
      try {
          $db = JDatabaseDriver::getInstance($driver);
      }
      catch (RuntimeException $ex) {
          if (!headers_sent()) {
              header('HTTP/1.1 500 Internal Server Error');
          }
          exit('Database Error: ' . $ex->getMessage());
      }
      return $db;
  }
  protected static function createSession()
  {
      $session = JSession::getInstance();
      if ($session->getState() == 'expired') {
          $session->restart();
      }
      return $session;
  }
  
  public function redirect($Vqr34rxwxwk1, $V5cbray2vfxf = '', $V5cbray2vfxfType = 'message', $Vtaisblrbeil = false)
  {
      if (preg_match('#^index2?\.php#', $Vqr34rxwxwk1)) {
          $Vqr34rxwxwk1 = JURI::base() . $Vqr34rxwxwk1;
      }
      $Vqr34rxwxwk1 = preg_split("/[\r\n]/", $Vqr34rxwxwk1);
      $Vqr34rxwxwk1 = $Vqr34rxwxwk1[0];
      if (!preg_match('#^http#i', $Vqr34rxwxwk1)) {
          $uri          = JURI::getInstance();
          $Vjzh212itrin = $uri->toString(array(
              'scheme',
              'user',
              'pass',
              'host',
              'port'
          ));
          if (isset($Vqr34rxwxwk1[0]) && $Vqr34rxwxwk1[0] == '/') {
              $Vqr34rxwxwk1 = $Vjzh212itrin . $Vqr34rxwxwk1;
          } else {
              $V3fo5n1pqffn = explode('/', $uri->toString(array(
                  'path'
              )));
              array_pop($V3fo5n1pqffn);
              $Vwoa4rqnjmar = implode('/', $V3fo5n1pqffn) . '/';
              $Vqr34rxwxwk1 = $Vjzh212itrin . $Vwoa4rqnjmar . $Vqr34rxwxwk1;
          }
      }
      if (!empty($V5cbray2vfxf) && trim($V5cbray2vfxf)) {
          $this->enqueueMessage($V5cbray2vfxf, $V5cbray2vfxfType);
      }
      
      if (headers_sent()) {
          echo "<script>document.location.href='" . htmlspecialchars($Vqr34rxwxwk1) . "';</script>\n";
      } else {
          jimport('phputf8.utils.ascii');
          if (($this->client->engine == JApplicationWebClient::TRIDENT) && !utf8_is_ascii($Vqr34rxwxwk1)) {
              echo '<html><head><meta http-equiv="content-type" content="text/html; charset=' . $document->getCharset() . '" />' . '<script>document.location.href=\'' . htmlspecialchars($Vqr34rxwxwk1) . '\';</script></head></html>';
          } else {
              header($Vtaisblrbeil ? 'HTTP/1.1 301 Moved Permanently' : 'HTTP/1.1 303 See other');
              header('Location: ' . $Vqr34rxwxwk1);
              header('Content-Type: text/html; charset=UTF-8');
          }
      }
      $this->close();
  }
}