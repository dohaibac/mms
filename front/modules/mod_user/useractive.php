<?php

// kiem tra xem co dung api_key khong?

$app_api_key = $this->appConf->app_api_key;
$app_secret  = $this->appConf->app_secret;

$api_key = isset($_GET['api_key']) ? $_GET['api_key'] : '';
$expires = isset($_GET['expires']) ? $_GET['expires'] : '';
$sign    = isset($_GET['sign'])    ? $_GET['sign'] : '';
$email   = isset($_GET['e'])       ? $_GET['e'] : '';

$data = array('type'=> 0, 'code'=>'ok', 'message'=>'OK');

if ($api_key != $app_api_key) {
  $data = array('type'=> 1, 'code'=> 'useractive-message-invalid_api_key', 'message'=>$this->lang('useractive-message-invalid_api_key'));
} else {
  $now = time();
  
  if ($now > $expires) {
    $data = array('type'=> 1, 'code'=> 'useractive-message-request_expired', 'message'=>$this->lang('useractive-message-request_expired'));
  }
  else {
    // check sign
    $valid_sign = generate_signal('GET', $app_secret, '/user-active', $expires, array('email'=>$email));
    if ($valid_sign != $sign) {
      $data = array('type'=> 1, 'code'=> 'useractive-message-invalid_sign', 'message'=>$this->lang('useractive-message-invalid_sign'));
    }
  }
}

$this->setVars(array('data'=>$data, 'email'=> $email));
$this->loadView('user/user_active');

?>