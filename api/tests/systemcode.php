<?php
include __DIR__ .'/common.php';
$base_url = 'http://api.am5.com';

function get_latest() {
  
  global $api_key;
  global $secret;
  
  $method = 'GET';
  $expires = time()+60;
  $request_path = '/systemcode/get_latest';
  $data = array();
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

get_latest();
