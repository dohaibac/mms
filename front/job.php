<?php

if (version_compare(PHP_VERSION, '5.3.1', '<'))
{
  die('Your host needs to use PHP 5.3.1 or higher!');
} 

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Global definitions
$parts = explode(DIRECTORY_SEPARATOR, __DIR__);
  
define('PATH_ROOT',  implode(DIRECTORY_SEPARATOR, $parts));

 
define('BASEPATH', __DIR__);

require_once BASEPATH . '/constants.php';
require_once BASEPATH . '/config/page.php';
require_once BASEPATH . '/includes/defined.php';
require_once BASEPATH . '/includes/framework.php';
require_once PATH_PLUGINS . '/cache/phpfastcache.php';

$app = JBase::getApplication(__APP_NAME__);

function send_notify($app, $registatoin_ids, $title, $message) {
  require_once PATH_COMPONENT . '/com_gcm/models/gcm.php';
    
  $gcm_model = new GcmModel($app);
  
  $data = array(
    'registatoin_ids' => array($registatoin_ids),
    'message' => array('title' => $title, 'content' => $message, 'timeStamp' => date('Y-m-d h:i:s'))
  );
  
  $result = $gcm_model->send_notification($data);
}

function get_list_device($app, $system_code) {
  require_once PATH_COMPONENT . '/com_gcm/models/gcm.php';
    
  $gcm_model = new GcmModel($app);
  
  $db = $app->getDbo();
   
  $where = 'system_code=' . $db->quote($system_code);
  
  $result = $gcm_model->get_list(array('where'=>$where));
  
  $ret = $result->body;
  
  return $ret;
}

function get_list_pds($app) {
  
  
} 

// lay thong tin PD
$ctrl = 'pd';
$task = 'get_list_for_job';

$controller = $app->getController($ctrl);

$pds = $controller->execute($task);
$pds = $pds->pds;

foreach($pds as $pd) {
  if ($pd->status == 3) {
    continue;
  }
  
  $timezone = new DateTimeZone('Asia/Ho_Chi_Minh');
  $issued_at = new DateTime($pd->issued_at, $timezone);
  
  // kiem tra xem $issued_at co lon hon ngay hien tai khong?
  $current_date_time = new DateTime(date('Y-m-d h:i:s'));
  $num_days_pending_date_time = $issued_at->add(new DateInterval('P'. $pd->num_days_pending .'D'));
  
  $system_code = $pd->system_code;
  
  $gcms = get_list_device($app, $system_code)->gcms;
  
  // den luc phai PD
  if ($current_date_time >= $num_days_pending_date_time) {
    // send
    $title = $pd->code . ' đã đến lúc PD.';
    $message = 'Sponsor : ' . $pd->sponsor;
    
    // lay tat ca thiet bi trong nhom system_code
    foreach($gcms as $gcm) {
      $gcm_regid = $gcm->gcm_regid;
      send_notify($app, $gcm_regid, $title, $message);
    }
  }
}

?>