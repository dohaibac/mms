<?php
defined('LIBS_PATH') or die;
class JBase
{
    public static $cache = null;
    public static $session = null;
    
    public $tpl = null;
    
    public $appConf = null;
    
    public $docs = null;
    
    public $uri = null;
    public static $db = null;
    
    public $client = null;
    public static $application = null;
    protected static $instance;
    
    protected $document = null;
    
    public function __construct()
    {
        $this->uri     = JUri::getInstance();
        
        $this->client  = new JApplicationWebClient();
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
            $V5utichma3rq = 'JApplication' . ucfirst($name);
            if (!class_exists($V5utichma3rq)) {
                throw new RuntimeException('APPLICATION_ERROR_APPLICATION_LOAD', 500);
            }
            static::$application[$name] = new $V5utichma3rq;
        }
        return static::$application[$name];
    }

    public function loadView($Vzpoegqk2ubg = '', $Vypcqv5ax20p = '.php')
    {
        if ($Vzpoegqk2ubg == '') {
            return;
        }
        $Vzpoegqk2ubg = '.' . '/views/' . $Vzpoegqk2ubg . $Vypcqv5ax20p;
        $this->setVars(array(
            'appConf' => $this->appConf
        ));
        $this->tpl->display($Vzpoegqk2ubg);
    }
    
    public function setVars($name = null, $data = array())
    {
        if ($name == null) {
            $this->tpl->assign($data);
        } else {
            $this->tpl->assign($name, $data);
        }
        return $this;
    }
    
    public function includes($Vmbg1atoo2v2 = '')
    {
        if (empty($Vmbg1atoo2v2))
            return;
        if (file_exists($Vmbg1atoo2v2)) {
            require_once($Vmbg1atoo2v2);
        } else {
            $Vmbg1atoo2v2 = $this->appConf->theme_path . '/' . $Vmbg1atoo2v2;
            if (file_exists($Vmbg1atoo2v2)) {
                require_once($Vmbg1atoo2v2);
            }
        }
    }
    public function loadHelper($name = '')
    {
        if (empty($name))
            return;
        $Vp3oo4ecirmd = explode('_', $name);
        $V0jocb0encsg = '';
        foreach ($Vp3oo4ecirmd as $Vxlxynx232mp) {
            $V0jocb0encsg = $V0jocb0encsg . ucfirst($Vxlxynx232mp);
        }
        if (empty($V0jocb0encsg))
            return;
        if (!class_exists($V0jocb0encsg)) {
            require_once(PATH_LIBRARIES . '/helper/' . $name . '.php');
        }
    }
    public static function getSession(array $options = array())
    {
        if (!self::$session) {
            self::$session = self::createSession($options);
        }
        return self::$session;
    }
    public static function getUser($Vk1ysvinuyzj = null)
    {
        return JUser::getInstance();
    }
    
    protected function getRouter()
    {
        return new JRouter($this);
    }
    
    protected static function createSession()
    {
        $session = JSession::getInstance();
        if ($session->getState() == 'expired') {
            $session->restart();
        }
        return $session;
    }
    
    public static function createCookie()
    {
        $Vajlmkfls4bk = new JCookie();
        return $Vajlmkfls4bk;
    }
    
    public function redirect($Vrw4bdiaetbg, $Vzn2i4whkbyy = '', $Vzn2i4whkbyyType = 'message', $Vlny33ve2mbz = false)
    {
        if (preg_match('#^index2?\.php#', $Vrw4bdiaetbg)) {
            $Vrw4bdiaetbg = JURI::base() . $Vrw4bdiaetbg;
        }
        $Vrw4bdiaetbg = preg_split("/[\r\n]/", $Vrw4bdiaetbg);
        $Vrw4bdiaetbg = $Vrw4bdiaetbg[0];
        if (!preg_match('#^http#i', $Vrw4bdiaetbg)) {
            $uri          = JURI::getInstance();
            $Vafquba4n1z3 = $uri->toString(array(
                'scheme',
                'user',
                'pass',
                'host',
                'port'
            ));
            if (isset($Vrw4bdiaetbg[0]) && $Vrw4bdiaetbg[0] == '/') {
                $Vrw4bdiaetbg = $Vafquba4n1z3 . $Vrw4bdiaetbg;
            } else {
                $Vp3oo4ecirmd = explode('/', $uri->toString(array(
                    'path'
                )));
                array_pop($Vp3oo4ecirmd);
                $Vmbg1atoo2v2 = implode('/', $Vp3oo4ecirmd) . '/';
                $Vrw4bdiaetbg = $Vafquba4n1z3 . $Vmbg1atoo2v2 . $Vrw4bdiaetbg;
            }
        }
        if (!empty($Vzn2i4whkbyy) && trim($Vzn2i4whkbyy)) {
            $this->enqueueMessage($Vzn2i4whkbyy, $Vzn2i4whkbyyType);
        }
        
        if (headers_sent()) {
            echo "<script>document.location.href='" . htmlspecialchars($Vrw4bdiaetbg) . "';</script>\n";
        } else {
            jimport('phputf8.utils.ascii');
            if (($this->client->engine == JApplicationWebClient::TRIDENT) && !utf8_is_ascii($Vrw4bdiaetbg)) {
                echo '<html><head><meta http-equiv="content-type" content="text/html; charset=' . $document->getCharset() . '" />' . '<script>document.location.href=\'' . htmlspecialchars($Vrw4bdiaetbg) . '\';</script></head></html>';
            } else {
                header($Vlny33ve2mbz ? 'HTTP/1.1 301 Moved Permanently' : 'HTTP/1.1 303 See other');
                header('Location: ' . $Vrw4bdiaetbg);
                header('Content-Type: text/html; charset=UTF-8');
            }
        }
      exit;
   }
  
   public static function getDbo() {
    if (!self::$db) {
        self::$db = self::createDbo();
    }
    return self::$db;
  }
   
   protected static function createDbo()
  {
      $driver = array(
          'driver' => 'simulator',
          'host' => 'localhost',
          'user' => 'root',
          'password' => '',
          'database' => 'sim',
          'prefix' => 'sim_'
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

   /***
    * Init rest client
    * */
   public function getRestClient() {
     require_once PATH_PLUGINS . '/restClient/rest_client.php';
     
     $appConf = JAppConf::getInstance();
     
     $base_url = $appConf->rest_id_base_url;
     $api_key  = $appConf->rest_id_api_key;
     $secret   = $appConf->rest_id_secret;
     $timeout  = $appConf->rest_id_timeout;
     
     return new RestClient($base_url, $api_key, $secret, $timeout);
   }
   
    /***
    * get email sender
    * */
   public function get_email_sender() {
     require_once PATH_PLUGINS . '/restClient/rest_client.php';
     
     $appConf = JAppConf::getInstance();
     
     $base_url = $appConf->rest_email_base_url;
     $api_key  = $appConf->rest_email_api_key;
     $secret   = $appConf->rest_email_secret;
     $timeout  = $appConf->rest_email_timeout;
     
     return new RestClient($base_url, $api_key, $secret, $timeout);
   }
}