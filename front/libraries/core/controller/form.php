<?php
defined('LIBS_PATH') or die;
abstract class JControllerForm
{
    public $app = null;
    public $Vxpgtpddvp04 = null;
    protected $task;
    protected $taskMap;
    protected $data = array();
    public $title = '';
    public $Vsyeskj45lx0 = '';
    protected $request_body ='';
    
    public function __construct($app)
    {
        $this->app = $app;
        $this->data =& $_REQUEST;
        
        $this->request_body = file_get_contents('php://input');
        
        $this->csrf    = new JCsrf();
        $Vwqwnvsxlrhs  = $this->csrf->generate();
        if (isset($this->data) && !empty($this->data[csrf_token])) {
            $this->csrf->check($this->data);
        }
        $Vwb0qcm5q5c4        = new stdClass;
        $Vwb0qcm5q5c4->value = $Vwqwnvsxlrhs;
        $Vwb0qcm5q5c4->name  = csrf_token;
        $this->app->setVars(array(
            'form_token' => $Vwb0qcm5q5c4
        ));
        $this->taskMap       = array();
        $Vshm0uri0j1s        = get_class_methods('JControllerForm');
        $Vm3dmv1oisgi        = new ReflectionClass($this);
        $Vm3dmv1oisgiMethods = $Vm3dmv1oisgi->getMethods(ReflectionMethod::IS_PUBLIC);
        foreach ($Vm3dmv1oisgiMethods as $Vm3dmv1oisgiMethod) {
            $Vtocttnfavko = $Vm3dmv1oisgiMethod->getName();
            if (!in_array($Vtocttnfavko, $Vshm0uri0j1s) || $Vtocttnfavko == 'display') {
                $this->methods[]                          = strtolower($Vtocttnfavko);
                $this->taskMap[strtolower($Vtocttnfavko)] = $Vtocttnfavko;
            }
        }
        
        JBase::getSession()->start();
    }
    public function execute($task = 'index', $Vxadok504pxa = array())
    {
        if (empty($task)) {
            $task = 'index';
        }
        $this->task = $task;
        $task       = strtolower($task);
        if (isset($this->taskMap[$task])) {
            $Vehf1ta30jem = $this->taskMap[$task];
        } elseif (isset($this->taskMap['__default'])) {
            $Vehf1ta30jem = $this->taskMap['__default'];
        } else {
            throw new Exception(sprintf('Task `%s` not found', $task), 404);
        }
        $this->doTask = $Vehf1ta30jem;
        if (empty($Vxadok504pxa)) {
            return $this->$Vehf1ta30jem();
        } else {
            return $this->$Vehf1ta30jem($Vxadok504pxa);
        }
    }
    public function get($name, $Vbueudrjyz5i = null, $Vxrlwl5dkrbd = 'cmd')
    {
        if (isset($this->data[$name])) {
            $Vxrlwl5dkrbdInput = new JFilterInput();
            return $Vxrlwl5dkrbdInput->clean($this->data[$name], $Vxrlwl5dkrbd);
        }
        return $Vbueudrjyz5i;
    }
    public function set($name, $Vdzptd40oher)
    {
        $this->data[$name] = $Vdzptd40oher;
    }
   
    public function back()
    {
        $Vm3dmv1oisgieferer = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];
        $this->app->redirect($Vm3dmv1oisgieferer);
    }
    
    public function getSafe($name, $Vbueudrjyz5iValue = '')
    {
      $method = strtoupper($_SERVER['REQUEST_METHOD']);
      
      $data = $this->data;
      
      if ($method == 'PUT' || $method == 'POST' || $method == 'DELETE') {
        $data = $this->get_request_body();
      }
      
      if (!empty($data) && isset($data[$name])) {
        return $data[$name];
      }
      return $Vbueudrjyz5iValue;
    }
    
    public function setVars($name = null, $data = array())
    {
        $this->app->setVars($name, $data);
    }
    public function loadView($Vedbs3olx4te = '', $Vszo2qcnx3hv = '.php')
    {
        $this->app->loadView($Vedbs3olx4te, $Vszo2qcnx3hv);
    }
    public function redirect($V1534aknwac1, $Vfagkn1ff03t = '', $Vfagkn1ff03tType = 'message', $Vt02sogjfry0 = false)
    {
        $this->app->redirect($V1534aknwac1, $Vfagkn1ff03t = '', $Vfagkn1ff03tType = 'message', $Vt02sogjfry0 = false);
    }

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
  
  public function system_code() {
    return $this->app->system_code();
  }
  public function get_request_body()
  {
    return json_decode($this->request_body, true);
  }
    
  /***
   * $code : 1: success, 0: fail
   * 
   * $type : text, 
   * 
   * $message: Message description
   * 
   * return array
   * 
   * */
   protected function message_response($code='', $type =  '', $message = '')
   {
      return array('response_code' => $code, 'response_type' => $type, 'response_message' => $message);
   }

  /***
   * check ajax required login
   * 
   * */
  public function check_ajax_required_login () {
    if ($this->app->user->isGuest()) {
      $login_url = $this->base_url .'/'. $this->lang('common-url-login') . '?from=' .urlencode($this->appConf->current_url);
      $ret = $this->message(1, 'required_login', 'Your request is required login');
      $ret['login_url'] = $login_url;
      $this->renderJson($ret);
    }
  }
  
  public function re_format_datetime($datetime) {
    $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
    $date =  new DateTime($datetime, $timezone);
    
    return  $date->format('Y-m-d H:i:s');  
  }
}