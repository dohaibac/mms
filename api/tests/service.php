<?php
$base_url = 'http://api.id.janet.vn';

function view_service_test () {
  $data = array(
    "id" => "1",
    'api_key' =>'4cef2a98940b4b6ebaae1a439181439d',
    'expires' => time() + 60,
    'sign'=> 'TO516FEkHE9431ELlvzhfQtVxD8lRfZAlkC8B2X%2Fexg'
  );
  global $base_url;
  
  $data['sign'] = generate_signal('GET', 'bef7d33a631bc16e', '/service', $data['expires']);
  
  $data_string = http_build_query($data);
  
  $ch = curl_init($base_url . '/service?' . $data_string);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function insert_service_test () {
  
  $data = array(
    "name" => 'web247',
    "block" => '1',
    'created_at'=>date('Y-m-d h:i:s'),
    'created_by'=> 1
  );
  
  $data_keys = array(
    'api_key' =>'4cef2a98940b4b6ebaae1a439181439d',
    'expires' => time() + 60,
    'sign'=> 'TO516FEkHE9431ELlvzhfQtVxD8lRfZAlkC8B2X%2Fexg'
  );
  $data_keys['sign'] = generate_signal('POST', 'bef7d33a631bc16e', '/service', $data_keys['expires']);
  $data_keys_string = http_build_query($data_keys);
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/service?' . $data_keys_string);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json', 
    'Content-Length: ' . strlen($data_string)) 
  ); 
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function update_service_test () {
  $data = array(
    "id" => "1", 
    "name"=>"domain",
    'code' =>'JAN01',
    'updated_at'=>date('Y-m-d h:i:s'),
    'updated_by'=>1 
  );
  
   $data_keys = array(
    'api_key' =>'4cef2a98940b4b6ebaae1a439181439d',
    'expires' => time() + 60,
    'sign'=> 'TO516FEkHE9431ELlvzhfQtVxD8lRfZAlkC8B2X%2Fexg'
  );
  $data_keys['sign'] = generate_signal('PUT', 'bef7d33a631bc16e', '/service', $data_keys['expires']);
  $data_keys_string = http_build_query($data_keys);
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/service?' . $data_keys_string);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json', 
    'Content-Length: ' . strlen($data_string)) 
  ); 
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function delete_service_test () {
  $data = array(
    "id" => "1"
  );
  
  $data_keys = array(
    'api_key' =>'4cef2a98940b4b6ebaae1a439181439d',
    'expires' => time() + 60,
    'sign'=> 'TO516FEkHE9431ELlvzhfQtVxD8lRfZAlkC8B2X%2Fexg'
  );
  $data_keys['sign'] = generate_signal('DELETE', 'bef7d33a631bc16e', '/service', $data_keys['expires']);
  $data_keys_string = http_build_query($data_keys);
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/service?' . $data_keys_string);
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

function get_list_service_test () {
  $data = array(
    'limit'=>2,
    'page_number'=>1,
    'keywords'=> '',
    'api_key' =>'4cef2a98940b4b6ebaae1a439181439d',
    'expires' => time() + 60,
    'sign'=> 'TO516FEkHE9431ELlvzhfQtVxD8lRfZAlkC8B2X%2Fexg'
  );
  global $base_url;
  $data['sign'] = generate_signal('GET', 'bef7d33a631bc16e', '/service/list', $data['expires']);
  $data_string = http_build_query($data);
  
  $url = '/service/list?' . $data_string;
  
  $ch = curl_init($base_url . $url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function generate_signal($method, $secret, $request_path, $expires) {
  $to_sign = $method . $secret . $request_path . $expires;
  
  $hash = hash("sha256", $to_sign, true);
  $base = base64_encode($hash);
  $base = substr($base, 0, 43);
  $base = urlencode($base);
  return $base;
}

//view_service_test();
 
//insert_service_test();

//update_service_test();
//delete_service_test();

get_list_service_test();

