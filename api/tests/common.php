<?php
$api_key = '4cef2a98940b4b6ebaae1a439181439d';
$secret = 'bef7d33a631bc16e';

function generate_signal($method, $secret, $request_path, $expires, $params=array(), $request_body="") {
  $to_sign = $method . $secret . $request_path . $expires;
  
  if (!empty($params)) {
    $keys = sortKeys($params);
    foreach ($keys as $key) {
      $to_sign .= $key . "=" . $params[$key];
    }
  }
  
  if (!empty($request_body)) {
    $to_sign .= $request_body;
  }
  
  $hash = hash("sha256", $to_sign, true);
  $base = base64_encode($hash);
  $base = substr($base, 0, 43);
  $base = urlencode($base);
  
  return $base;
}

function sortKeys ($array) {
  $keys = array();$ind=0;
  foreach ($array as $key => $val) {
    $keys[$ind++]=$key;
  }
  sort($keys);
  return $keys;
}