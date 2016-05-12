<?php
include __DIR__ .'/common.php';
$base_url = 'http://api.am5.com';

function get_by_username() {
  $method = 'GET';
  $expires = time()+60;
  $request_path = '/sponsor/get_by_username';
  $data = array('username'=>'dtp1');
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

function delete() {
  $method = 'DELETE';
  $expires = time()+60;
  $request_path = '/group';
  $data = array('id'=>'14', 'system_code'=>06);
  
  $data_keys = array();
  
  $data_keys['api_key'] = '4cef2a98940b4b6ebaae1a439181439d';
  $data_keys['expires'] = $expires;
  $data_keys['sign'] = generate_signal($method, 'bef7d33a631bc16e', $request_path, $expires, $data);
  
  $data_string = json_encode($data);
  
  global $base_url;
  
  $data_key_string = http_build_query($data_keys);
  $url = $base_url . $request_path . '?' . $data_key_string;
   
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json', 
    'Content-Length: ' . strlen($data_string)) 
  ); 
  
  
  $result = curl_exec($ch);
  
  print_r($result);
}
delete();
