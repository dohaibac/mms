<?php
defined('LIBS_PATH') or die;

class JAppConf 
{
  public $app_name = '';
  public $copyright = '';
  public $base_url = '';
  public $base_domain = '';
  
  public $theme_name = '';
  public $theme_css_version = '';
  public $theme_js_version = '';
  
  public $cookie_domain = '';
  public $cookie_path = '';
 
  public $page_size = '';
  public $smarty_cache = '';
  public $debug_mode = '';

  public $enable_zip_page = 0;
  public $enable_random_form_name = 0;
  
  public $language = '';
  
  public $app_api_key = '';
  public $app_secret = '';
  
  public $rest_id_base_url = '';
  public $rest_id_api_key = '';
  public $rest_id_secret = '';
  public $rest_id_timeout = '';
  
  public $rest_email_base_url = '';
  public $rest_email_api_key = '';
  public $rest_email_secret = '';
  public $rest_email_timeout = '';
  
  public $cdn_base_url = '';
  
  // custom variables
  
  public $theme_default = '';
  
  //absolute theme
  public $theme = '';
  public $theme_path = '';
  public $domain = '';
  public $full_domain = '';
  public $current_url = '';
  public $current_url_path = '';
  
  public $ctrl = '';
  public $task = '';
  
  public $default_system_code = '';
  
  protected static $instance;
  
  public static function getInstance() {
    if (!is_object(self::$instance)) {
        self::$instance = new JAppConf();
    }
    return self::$instance;
  }
  
  public function __construct() {
    
    $this->app_name = JConfig::get('APP_NAME');
    $this->copyright = JConfig::get('COPYRIGHT');
    
    $this->base_url = JConfig::get('BASE_URL');
    $this->base_domain = JConfig::get('BASE_DOMAIN');
    
    $this->theme_name = JConfig::get('THEME_NAME');
    $this->theme_css_version = JConfig::get('THEME_CSS_VERSION');
    $this->theme_js_version = JConfig::get('THEME_JS_VERSION');
    
    $this->cookie_domain = JConfig::get('COOKIE_DOMAIN');
    $this->cookie_path = JConfig::get('COOKIE_PATH');
    
    $this->page_size = JConfig::get('PAGE_SIZE');
    $this->smarty_cache = JConfig::get('SMARTY_CACHE');
    $this->debug_mode = JConfig::get('DEBUG_MODE');
    
    $this->enable_zip_page = JConfig::get('ENABLE_ZIP_PAGE');
    $this->enable_random_form_name = JConfig::get('ENABLE_RANDOM_FORM_NAME');
    
    $this->language = JConfig::get('LANGUAGE');
    
    $this->app_api_key = JConfig::get('APP_API_KEY');
    $this->app_secret = JConfig::get('APP_SECRET');
    
    // ket noi den id.janet.vn
    $this->rest_id_base_url   = JConfig::get('REST_ID_BASE_URL');
    $this->rest_id_api_key   = JConfig::get('REST_ID_API_KEY');
    $this->rest_id_secret   = JConfig::get('REST_ID_SECRET');
    $this->rest_id_timeout   = JConfig::get('REST_ID_TIME_OUT');
    
    $this->rest_email_base_url   = JConfig::get('REST_EMAIL_BASE_URL');
    $this->rest_email_api_key   = JConfig::get('REST_EMAIL_API_KEY');
    $this->rest_email_secret   = JConfig::get('REST_EMAIL_SECRET');
    $this->rest_email_timeout   = JConfig::get('REST_EMAIL_TIME_OUT');
    
    $this->cdn_base_url   = JConfig::get('CDN_BASE_URL');
    
    $this->default_system_code = JConfig::get('DEFAULT_SYSTEM_CODE');
  }
  
}