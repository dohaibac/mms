 <?php
defined('LIBS_PATH') or die;
class JApplicationEcms extends JBase {
  
  public $langConf = array();
  
  public $routerConf = array();
  public $currentPage = array();
  public $options = array();
  public $user = array();
  
  public $base_url = '';
  
  public function __construct() {
    
    parent::__construct();
    
    $this->init();
    
    $this->set_app_cookie();
    
    self::getSession()->start();;
    
    $this->prevent_csrf();
  
    $this->prevent_access_index_php();
      
    $this->detect_language();
  }
  
  /***
   * Init tpl, document
   * 
   * */
  private function init() {
    require_once PATH_LIBRARIES .'/core/config/appConfig.php';
    
    $this->appConf = JAppConf::getInstance();
        
    $this->base_url   = $this->appConf->base_url;
    
    $this->appConf->theme_default = $this->base_url . '/themes/default';
    
    $this->appConf->theme         =  $this->base_url . '/' . 'themes/' . $this->appConf->theme_name;
    $this->appConf->theme_path    = PATH_THEMES . '/' . $this->appConf->theme_name;
    
    $this->appConf->domain        = $this->uri->getHost();
    $this->appConf->full_domain   = $this->uri->getScheme() . '://' . $this->uri->getHost();
    
    $this->appConf->current_url   =  $this->uri->getScheme() . '://' . $this->uri->getHost() . $this->uri->getPath();
    $this->appConf->current_url_path =  $this->uri->getPath();
    
    $this->appConf->ctrl = __ctrl__;
    $this->appConf->task = __task__;
    
    // set pageConf
    global $pageConf;
    $this->pageConf = $pageConf;
    
    $this->tpl = new Smarty();
    $this->tpl->template_dir = '.' . "/views";
    $this->tpl->setCompileDir('.' . '/compile')->setCacheDir('.' . '/cache');
    $this->tpl->cache_lifetime = 900;
    $this->tpl->caching        = $this->appConf->smarty_cache;
    
    $this->document = new JDocumentAdmin(array(), __APP_NAME__);
    
    // init user
    $this->user = JUser::getInstance();
  }
  
  private function prevent_csrf() {
    if (!isset($_COOKIE['csrftoken'])) {
        $Vajlmkfls4bk = self::createCookie();
        $this->csrf   = new JCsrf();
        $Vkkb3rnp3hmh = $this->csrf->generate();
        $Vajlmkfls4bk->set('csrftoken', $Vkkb3rnp3hmh, 0, '/', $this->appConf->cookie_domain);
    }
    
    if (strtoupper($_SERVER['REQUEST_METHOD']) != 'GET' 
      && isset($_COOKIE['csrftoken']) && $_SESSION[csrf_token] != $_COOKIE['csrftoken']) {
        $cookie = self::createCookie();
        $cookie->set('csrftoken', null, -1, '/', $this->appConf->cookie_domain);
        
        $this->user->logout();
        
        $this->redirect('/');
    }
  }
  /***
   * Chan khong cho vao index.php
   * 
   * */
  private function prevent_access_index_php () {
    $uri_path     = $this->uri->getPath();
    
    if (strpos($uri_path, '/index.php') !== false) {
        header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
        header("Status: 404 Not Found");
        $_SERVER['REDIRECT_STATUS'] = 404;
        include BASEPATH . '/errors.php';
        exit;
    }
    
  }
  
  /***
   * Chan khong cho request tu site khach
   * 
   * */
  public function prevent_remote_access () {
    $base_domain = $this->appConf->base_domain;
    
    if (!isset($_SERVER['HTTP_REFERER']) || (isset($_SERVER['HTTP_REFERER'])
     && strpos($_SERVER['HTTP_REFERER'], $base_domain) === false)) {
      die('InvalidRequest!');
    }
  }
  
  public function execute() {
    
    JApplicationHelper::findOption();
    
    $opt  = $this->uri->getVar(__ctrl__);
    $task = $this->uri->getVar(__task__);
    $mod  = $this->uri->getVar('mod');
    
    if (!empty($mod)) {
      exit($this->renderModule($mod));
    }
    if (isset($opt) && !empty($opt)) {
      $this->options = array(__ctrl__ => $opt, __task__=>$task);
    }
    //print_r($this->options);exit;
    if (!empty ($this->options)) {
      JComponentHelper::renderComponent('com_' . $this->options[__ctrl__]);
    }
    
    // neu co controller va action khong
    if (!empty ($this->options)) {
      $contents      = JComponentHelper::renderComponent('com_' . $this->options[__ctrl__]);
      exit($contents);
    }
    
    // khong tim thay page nao
    if (empty($this->currentPage)) {
      header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
      header("Status: 404 Not Found");
      
      $_SERVER['REDIRECT_STATUS'] = 404;
      
      include BASEPATH . '/errors.php';
      exit;
    }
    
    // kiem tra xem page nay co yeu cau login hay khong
    if (isset($this->currentPage['required_login']) && $this->currentPage['required_login']) {
      // neu user chua login, redirect login page
      if ($this->user->isGuest()) {
        if ($this->appConf->current_url_path == '/') {
          $this->redirect($this->base_url .'/'. $this->lang('common-url-login'));
        }
        else {
          $this->redirect($this->base_url .'/'. $this->lang('common-url-login') . '?from=' .urlencode($this->appConf->current_url));
        }
      }
    }
    
    $this->theme_page_name = JApplicationHelper::get_theme_page_name();
    
    $data  = array(
      'file' => $this->appConf->theme_path . '/'. $this->theme_page_name .'.php' 
    );
    
    $this->document->setBuffer('', 'component');
    $this->document->render($data);
  }
  
  public function getController($name, $basePath = '') {
    $className = ucfirst($name) . 'Controller';
    if (!class_exists($className)) {
      $path = PATH_COMPONENT . '/com_' . $name . '/controller.php';
      
      if (file_exists($path)) {
        require_once $path;
      } else {
        throw new InvalidArgumentException(sprintf('Invalid controller `%s`', $name));
      }
    }
    if (!class_exists($className)) {
      throw new RuntimeException(sprintf('Unable to locate controller `%s`.', $className), 404);
    }
    $controller = new $className($this);
    return $controller;
  }
  
  public function loadView($name = '', $ext = '.php') {
    if ($name == '') {
        return;
    }
    
    $path = '.' . '/views/' . $name . $ext;
    
    $this->setVars(array(
      'app' => $this
    ));
    
    $this->tpl->display($path);
  }
  
  public function renderModule($name = '', $params = array(), $content = null) {
    if ($name == '') {
      return;
    }
    
    $path = PATH_MODULES . '/' . 'mod_' . strtolower($name) . '/' . $name . '.php';
    
    if (strpos($name, '.') !== FALSE) {
      list($Vvej04prue52, $Vamlrvhtdjfb) = explode('.', $name);
      $task         = $Vamlrvhtdjfb;
      $name         = $Vvej04prue52;
      
      $path = PATH_MODULES . '/' . 'mod_' . strtolower($name) . '/' . $task . '.php';
    }
    
    $content = '';
    
    ob_start();
    $this->includes($path);
    $content = ob_get_contents();
    ob_end_clean();
    
    return $content;
  }
  
  public function renderModules($pos_name = '', $params = array(), $content = null)
  {
      if (empty($pos_name)) {
          return;
      }
      
      $content = '';
      $mods = JApplicationHelper::get_list_modules($pos_name);
      
      if (empty ($mods)) {
        return '';
      }
      $mods = explode(',', $mods);
      
      foreach ($mods as $mod) {
          $content .= $this->renderModule(trim($mod), $params, $content);
      }
      return $content;
  }
  /***
   * detect ngon ngu site?
   * */
  public function detect_language () {
    require_once PATH_LANGUAGES . '/' . $this->appConf->language . '/languages.php';
    
    $this->langConf = $langConf;
    
    // require router
    require_once PATH_LANGUAGES . '/' . $this->appConf->language . '/router_locale.php';
    
    $this->routerConf = $routerConf;
  }
  
  /****
   * Lay language settings theo $key
   * 
   * Neu khong tim thay se return theo $key
   * 
   * */
  public function lang($lang_key) {
    $langConf = $this->langConf;
    
    foreach ($langConf as $key => $val) {
      if ($key == $lang_key) {
        return $val;
      }
    }
    
    return $lang_key;
  }
  
  /****
   * Lay short string 
   * max length <=40 character
   * */
  public function substr($str, $len=40) {
    if (strlen($str) > $len) {
      return substr($str, 0, $len) . '..';
    }
    return $str;
  }
  
  /***
   * Lay noi dung file template
   * */
  public function get_content_template($template_path, $data) {
    $this->setVars($data);
    
    ob_start();
    $this->tpl->display($template_path);
    $content =  ob_get_contents();
    ob_end_clean();
    
    return $content;
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

  public function system_code() {
    return $this->user->data()->system_code;
  }
}