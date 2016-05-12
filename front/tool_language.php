<?php

/***
 * Tool nay cho phep zip toan bo file dinh nghia trong folder languages/[vi] thanh mot file duy nhat
 * 
 * Muc dich lam tang toc do 
 * 
 * **/
$target_generate_file_name = 'languages.php'; // file sinh ra
$excude_files = array ('router_locale.php'); // danh sach files khong dong goi
  
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'vi';

$language_dir = __DIR__ . '/languages/' . $lang;

// xoa file da co
$target_generate_file_path = $language_dir . '/' . $target_generate_file_name;

if (file_exists($target_generate_file_path)) {
  unlink($target_generate_file_path);
}

$files = glob($language_dir . "/*.php");

$langConf = array ();
foreach($files as $file) {
  $file_name = basename($file);
  if (in_array ($file_name, $excude_files)) {
    continue;
  }
  
  $lang = include $file;
  foreach ($lang as $key=>$val) {
    $langConf[$key]= $val;
  }
}

@file_put_contents($target_generate_file_path, '<?php $langConf = ' . var_export($langConf, true) . ';');
echo 'Done!';
