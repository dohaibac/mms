<?php
defined('LIBS_PATH') or die;
abstract class JControllerForm
{
  public $app = null;
  protected $task;
  protected $taskMap;
  protected $data = array();
  protected $request_body ='';
  public $title = '';
  
  public function __construct($app)
  {
      $this->app = $app;
      $this->data =& $_REQUEST;
      $this->request_body = file_get_contents('php://input');
      
      $this->taskMap       = array();
      $Vpuwag13ixts        = get_class_methods('JControllerForm');
      $V3mpbqgljpdt        = new ReflectionClass($this);
      $V3mpbqgljpdtMethods = $V3mpbqgljpdt->getMethods(ReflectionMethod::IS_PUBLIC);
      foreach ($V3mpbqgljpdtMethods as $V3mpbqgljpdtMethod) {
          $Vw3yjdvqwrzn = $V3mpbqgljpdtMethod->getName();
          if (!in_array($Vw3yjdvqwrzn, $Vpuwag13ixts) || $Vw3yjdvqwrzn == 'display') {
              $this->methods[]                          = strtolower($Vw3yjdvqwrzn);
              $this->taskMap[strtolower($Vw3yjdvqwrzn)] = $Vw3yjdvqwrzn;
          }
      }
  }
  public function execute($task = 'index', $Vspgstpuh0o5 = array())
  {
      $this->authen_validate();
      
      if (empty($task)) {
          $task = 'index';
      }
      $this->task = $task;
      $task       = strtolower($task);
      if (isset($this->taskMap[$task])) {
          $V5mw05debi21 = $this->taskMap[$task];
      } elseif (isset($this->taskMap['__default'])) {
          $V5mw05debi21 = $this->taskMap['__default'];
      } else {
          throw new Exception(sprintf('Task `%s` not found', $task), 404);
      }
      $this->doTask = $V5mw05debi21;
      if (empty($Vspgstpuh0o5)) {
          return $this->$V5mw05debi21();
      } else {
          return $this->$V5mw05debi21($Vspgstpuh0o5);
      }
  }
  
  public function get($name, $Vh4ul5e10n3q = null, $Vnvl3wuae3nu = 'cmd')
  {
      if (isset($this->data[$name])) {
          $Vnvl3wuae3nuInput = new JFilterInput();
          return $Vnvl3wuae3nuInput->clean($this->data[$name], $Vnvl3wuae3nu);
      }
      return $Vh4ul5e10n3q;
  }
  
  public function set($name, $val)
  {
      $this->data[$name] = $val;
  }
  
  public function getSafe($name, $default_value = '')
  {
      $data = $this->data;
      if (!empty($data) && isset($data[$name])) {
          return $data[$name];
      }
      return $default_value;
  }
  public function get_request_body()
  {
    return json_decode($this->request_body, true);
  }
  /****
   * Render json format
   * 
   * $data array
   * 
   */
  protected function renderJson($ret)
  {
      header('Content-Type: application/json');
      exit(json_encode($ret));
  }
  
/***
 * $type : 0 or 1 --> 0: success, 1: error;
 * 
 * $code : Message Code. Code should be prefix with model name
 * ex: if it write in model user, $code should be user_xxx
 * 
 * $message: Message description
 * 
 * return array
 * 
 * */
  protected function message($type = 0, $code='', $message = '')
  {
    return array('type' => $type, 'code' => $code, 'message' => $message);
  }
  
  /****
   * function nay se kiem tra quest den co duoc cho phep khong va duoc phep execute method nao
   * 
   * */
  protected function authen_validate () {
    $required_params = array('api_key', 'expires', 'sign');
    
    foreach($required_params as $key) {
      $val = $this->getSafe($key, '');
      if (empty($val)) {
        $ret = $this->message(1, 'api_authen_validate_missing_'. $key, 'Missing or Empty '. $key);
        $this->renderJson($ret);
      }
    }
    
    $api_key = $this->getSafe('api_key');
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    $request_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $expires = $this->getSafe('expires');
    $sign = $this->getSafe('sign');
    
    $query_string = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    
    parse_str($query_string, $query_array);
    
    if (!empty ($query_array)) {
      unset($query_array['api_key']);
      unset($query_array['expires']);
      unset($query_array['sign']);
    }
    
    // check expired time;
    
    $now = time();
    
    $expires = intval ($expires);
    
    if ($now > $expires) {
      $ret = $this->message(1, 'api_authen_validate_request_expired', 'Your request has expired.');
      $this->renderJson($ret);
    }
     
    $secret = 'bef7d33a631bc16e';
    
    $verify_sign = generate_signal($method, $secret, $request_path, $expires, $query_array, $this->request_body);
    
    if ($verify_sign != $sign) {
      $ret = $this->message(1, 'api_authen_validate_sign_invalid', 'sign invalid.');
      $this->renderJson($ret);
    }
  }
}