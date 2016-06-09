<?php
defined('LIBS_PATH') or die;

class JAppConf 
{
  public $app_name = '';
  public $base_url = '';
  public $base_domain = '';
  
  public $cookie_domain = '';
  public $cookie_path = '';

  public $smarty_cache = '';
  public $page_size = '';
  public $debug_mode = '';

  public $service_code_prefix = '';
  public $token_expired_time = '';
  public $api_code = '';
  public $app_secret = '';

  public $db_host = '';
  public $db_user = '';
  public $db_password = '';
  public $db_name = '';
  public $db_driver = '';
  public $db_prefix = '';

  public $google_api_key = '';
  public $google_gcm_sender_id = '';
  
  public $log_file = '';
  
  public $email_user_name = '';
  public $email_password = '';
  
  protected static $instance;
  
  public static function getInstance() {
    if (!is_object(self::$instance)) {
        self::$instance = new JAppConf();
    }
    return self::$instance;
  }
  
  public function __construct() {
    
    $this->app_name = JConfig::get('APP_NAME');
    
    $this->base_url = JConfig::get('BASE_URL');
    $this->base_domain = JConfig::get('BASE_DOMAIN');
    $this->cookie_domain = JConfig::get('COOKIE_DOMAIN');
    $this->cookie_path = JConfig::get('COOKIE_PATH');
    
    $this->page_size = JConfig::get('PAGE_SIZE');
    $this->smarty_cache = JConfig::get('SMARTY_CACHE');
    $this->debug_mode = JConfig::get('DEBUG_MODE');
    
    $this->service_code_prefix = JConfig::get('SERVICE_CODE_PREFIX');
    $this->token_expired_time = JConfig::get('TOKEN_EXPIRED_TIME');
    $this->api_code = JConfig::get('API_CODE');
    $this->app_secret = JConfig::get('APP_SECRET');
    
    // config for db
    $this->db_host   = JConfig::get('DB_HOST');
    $this->db_user   = JConfig::get('DB_USER');
    $this->db_password   = JConfig::get('DB_PASS');
    $this->db_name   = JConfig::get('DB_NAME');
    $this->db_driver   = JConfig::get('DB_DRIVER');
    $this->db_prefix   = JConfig::get('DB_PREFIX');
    
    $this->log_file   = JConfig::get('LOG_FILE');
    
    $this->google_api_key   = JConfig::get('GOOGLE_API_KEY');
    $this->google_gcm_sender_id  = JConfig::get('GOOGLE_GCM_SENDER_ID');
    
    $this->email_user_name  = JConfig::get('EMAIL_USERNAME');
    $this->email_password  = JConfig::get('EMAIL_PASSWORD');
  }
}