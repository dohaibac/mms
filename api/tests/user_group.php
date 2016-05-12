<?php
$base_url = 'http://api.id.janet.vn';

function view_usergroup_test () {
  $data = array(
    "id" => "1"
  );
  global $base_url;
  
  $data_string = http_build_query($data);
  
  $ch = curl_init($base_url . '/usergroup?' . $data_string);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function insert_usergroup_test () {
  $data = array(
    "name" => "Test user group", 
    'ord'=>'123',
    'created_at'=>date('Y-m-d h:i:s'),
    'created_by'=> 1
  );
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/usergroup');
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

function update_usergroup_test () {
  $data = array(
    "id" => "7", 
    'updated_at'=>date('Y-m-d h:i:s'),
    'updated_by'=>1,
    'description'=>'test',
    'ord'=>1
  );
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/usergroup');
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

function delete_usergroup_test () {
  $data = array(
    "id" => "7"
  );
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/usergroup');
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

function get_list_usergroup_test () {
  $data = array(
    'limit'=>2,
    'page_number'=>1,
    'keywords'=> ''
  );
  global $base_url;
  
  $data_string = http_build_query($data);
  
  $ch = curl_init($base_url . '/usergroup/list?' . $data_string);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

//view_usergroup_test();
 
//insert_usergroup_test();

//update_usergroup_test();
//delete_usergroup_test();

//get_list_usergroup_test();

