<?php
$base_url = 'http://api.id.janet.vn';

include_once __DIR__ . '/common.php';

function view_devkey_test () {
  $data = array(
    "id" => "1"
  );
  global $base_url;
  
  $data_string = http_build_query($data);
  
  $ch = curl_init($base_url . '/devkey?' . $data_string);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function insert_devkey_test () {
  global $api_key;
  global $secret;
  require_once(__DIR__ . '/../plugins/uuid/uuid.php');
  
  $api_key_generate = str_replace('-', '', UUID::v4());
  $secret_generate = substr(str_replace('-', '', UUID::v4()), 16);
   
  $data = array(
    "api_key" => $api_key_generate, 
    "secret" => $secret_generate,
    "app_name" => 'front_api_emso',
    "api_code" => 'api_emso',
    "allow_ips" => '127.0.0.1',
    'created_at'=>date('Y-m-d h:i:s'),
    'created_by'=> 1
  );
  
  $data_keys = array(
    'api_key' => $api_key,
    'expires' => time() + 60
  );
  
  $data_keys['sign'] = generate_signal('POST', $secret, '/devkey', $data_keys['expires'], array(), json_encode($data));
  
  $data_keys_string = http_build_query($data_keys);
  

  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/devkey?' . $data_keys_string);
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

function update_devkey_test () {
  $data = array(
    "id" => "5", 
    'updated_at'=>date('Y-m-d h:i:s'),
    'updated_by'=>1,
    'api_key'=>'f5ea7d74ac0d459ebb6dfb5d7255e330',
  );
  
  $data_keys = array (
    'api_key' => 'f5ea7d74ac0d459ebb6dfb5d7255e330',
    'expires' => time() + 60,
    'sign'=> 'TO516FEkHE9431ELlvzhfQtVxD8lRfZAlkC8B2X%2Fexg'
  );
  
  
  $data_keys_string = http_build_query($data_keys);
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/devkey?' . $data_keys_string);
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

function delete_devkey_test () {
  $data = array(
    "id" => "1"
  );
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/devkey');
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

function get_list_devkey_test () {
  $data = array(
    'limit'=>2,
    'page_number'=>1,
    'keywords'=> '',
    'api_key' =>'4cef2a98940b4b6ebaae1a439181439d',
    'expires' => time() + 60,
    'sign'=> 'TO516FEkHE9431ELlvzhfQtVxD8lRfZAlkC8B2X%2Fexg'
  );
  global $base_url;
  $data['sign'] = generate_signal('GET', 'bef7d33a631bc16e', '/devkey/list', $data['expires']);
  $data_string = http_build_query($data);
  
  $url = '/devkey/list?' . $data_string;
  
  $ch = curl_init($base_url . $url);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

//view_devkey_test();
 
insert_devkey_test();

//update_devkey_test();
//delete_devkey_test();

//get_list_devkey_test();

