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

function get_by_group_id() {
   global $api_key;
  global $secret;
  
  $method = 'GET';
  $expires = time()+60;
  $request_path = '/user/get_by_group_id';
  $data = array('group_id'=>'1', 'system_code'=>'06');
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

get_by_group_id();
