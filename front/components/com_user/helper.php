<?php
defined('BASEPATH') or die;

class UserHelper 
{
  public function __construct($app) {
    $this->app = $app;
    
  }
  
  public function set_check_password2 ($user) {
    // kiem tra xem user co bat flag check password2 khong?
    
    $enable_security = $user->enable_security;
    
    if ($enable_security) {
      // random code 
      $code = rand(1000, 9999);
      
      $session = JBase::getSession();
      
      $session->set('check_password2', true);
      $session->set('check_password2_code', $code);
      
      // send code qua email hoac message
      $send_code = $user->send_code;
      
      $data = array (
        'user_id' => $user->id,
        'email' => $user->email,
        'send_code' => $send_code,
        'code' => $code
      );
      
      require_once PATH_COMPONENT . '/com_sendcode/models/sendcode.php';
      $sendcode_model = new SendcodeModel($this->app);
      
      $sendcode_model->send_code($data);
    }
  }
}
?>