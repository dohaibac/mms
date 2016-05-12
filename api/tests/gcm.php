<?php
$base_url = 'http://am5.com/gcm';

function view_user_test () {
 /* $data = array(
    "email" => "phuongdt606_test5@gmail.com"
  );
  */
  $data = array(
    "id" => "9"
  );
  global $base_url;
  
  $data_string = http_build_query($data);
  
  $ch = curl_init($base_url . '/user?' . $data_string);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function insert_gcm_test () {
  $data = array(
    "email" => "phuong.tran@gmail.com", 
    "password" => "12345678",
    "gcm_regid" => "gcmid2",
    'system_code'=>'06',
    'hardware_id'=> '1234567',
    'hardware_info' => 'Samsung'
  );
  
  $data_string = json_encode($data);
  
  global $base_url;
  
  $ch = curl_init($base_url. '/register');
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

function update_user_test () {
  $data = array(
    
    "email" => "phuongdt606_test6@gmail.com",
    'updated_at'=>date('Y-m-d h:i:s'),
    'updated_by'=>1,
    'mobile'=>'124',
    'password'=>'3333132333',
    'user_name'=>'1'
    /*'created_at'=>date('Y-m-d h:i:s'),
    'group_id' => 6,
    'created_by'=> 1,
    'display_name'=> 'Đinh Thế Phương'*/
  );
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/user');
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

function delete_user_test () {
  $data = array(
    "user_name" => "TESTAPI", 
    "email" => "phuongdt606_test1@gmail.com",
    'password'=>'123',
    'created_at'=>date('yy-mm-dd hh:mm:ss'),
    'group_id' => 6,
    'created_by'=> 1,
    'display_name'=> 'Đinh Thế Phương'
  );
  
  $data_string = json_encode($data);
  
  $ch = curl_init('http://api.id.janet.vn/user');
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

function get_list_user_test () {
  $data = array(
    "id" => "9",
    'limit'=>10,
    'page_number'=>1,
    'keywords'=> 'the'
  );
  global $base_url;
  
  $data_string = http_build_query($data);
  
  $ch = curl_init($base_url . '/user/list?' . $data_string);
  
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $result = curl_exec($ch);
  
  print_r($result);
}

function logout_test() {
  $data = array(
    "email" => "phuongdt606@gmail.com", 
    "password" => "12345678",
    "gcm_regid" => "gcmid2",
    'system_code'=>'06',
    'hardware_id'=> '123456',
    'hardware_info' => 'Samsung'
  );
  
  $data_string = json_encode($data);
  
  global $base_url;
  
  $ch = curl_init($base_url. '/logout');
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

//view_user_test();

//view_user_include_password_test();

insert_gcm_test();

//update_user_test();
// delete_user_test();

//get_list_user_test ();
//logout_test();
