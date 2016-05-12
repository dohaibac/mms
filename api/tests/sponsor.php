<?php
include __DIR__ .'/common.php';
$base_url = 'http://api.am5.com';

function get_by_username() {
  
  global $api_key;
  global $secret;
  
  $method = 'GET';
  $expires = time()+60;
  $request_path = '/sponsor/get_by_username';
  $data = array('username'=>'dtp1');
  $data_keys = $data;
  
  $data_keys['api_key'] = $api_key;
  $data_keys['expires'] = $expires;
  $data_keys['sign'] = generate_signal($method, $secret, $request_path, $expires, $data);
  
  global $base_url;
  
  $data_string = http_build_query($data_keys);
  $url = $base_url . $request_path . '?' . $data_string;
   
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function get_upline() {
  $method = 'GET';
  $expires = time()+60;
  $request_path = '/sponsor/get_upline';
  $data = array('username'=>'dtp');
  $data_keys = $data;
  
  $data_keys['api_key'] = '4cef2a98940b4b6ebaae1a439181439d';
  $data_keys['expires'] = $expires;
  $data_keys['sign'] = generate_signal($method, 'bef7d33a631bc16e', $request_path, $expires, $data);
  
  global $base_url;
  
  $data_string = http_build_query($data_keys);
  $url = $base_url . $request_path . '?' . $data_string;
   
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}


function get_by_email() {
   global $api_key;
  global $secret;
  
  $method = 'GET';
  $expires = time()+60;
  $request_path = '/user/get_by_email';
  $data = array('email'=>'dtp1@gmail.com', 'system_code'=>'06');
  $data_keys = $data;
  
  $data_keys['api_key'] = $api_key;
  $data_keys['expires'] = $expires;
  $data_keys['sign'] = generate_signal($method, $secret, $request_path, $expires, $data);
  
  global $base_url;
  
  $data_string = http_build_query($data_keys);
  $url = $base_url . $request_path . '?' . $data_string;
   
  $ch = curl_init($url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}
//get_upline();
//get_by_username();
get_by_email();
