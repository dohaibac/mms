<?php
defined('BASEPATH') or die;

class JobsAlert
{
  protected $app = '';
  protected $system_code = '';
  
  public function __construct($app, $system_code) {
    $this->app = $app;
    $this->system_code = $system_code;
    
    require_once PATH_COMPONENT .'/com_setting/models/setting.php';
    require_once PATH_COMPONENT .'/com_pd/models/pd.php';
    require_once PATH_COMPONENT .'/com_gd/models/gd.php';
    require_once PATH_COMPONENT .'/com_sponsor/models/sponsor.php';
    require_once PATH_COMPONENT .'/com_sponsorinvest/models/sponsorinvest.php';
    require_once PATH_COMPONENT .'/com_systemcode/models/systemcode.php';
    require_once PATH_COMPONENT .'/com_planpd/models/planpd.php';
    require_once PATH_COMPONENT .'/com_pdex/models/pdex.php';
    require_once PATH_COMPONENT .'/com_planget/models/planget.php';
    require_once PATH_COMPONENT .'/com_gcm/models/gcm.php';
    
    $this->setting_model = new SettingModel($app);
    $this->pd_model = new PdModel($app);
    $this->gd_model = new GdModel($app);
    $this->sponsor_model = new SponsorModel($app);
    $this->sponsorinvest_model = new SponsorinvestModel($app);
    $this->systemcode_model = new SystemcodeModel($app);
    $this->planpd_model = new PlanpdModel($app);
    $this->planget_model = new PlangetModel($app);
    
    $this->pdex_model = new PdexModel($app);
    $this->gcm_model = new GcmModel($app);
    
    $this->db = JBase::getDbo();
  }

  public function get_devices () {
    $db = $this->app->getDbo();
    
    $where = 'system_code=' . $db->quote($this->system_code) . ' AND block=0';
    
    $order_by ='id DESC';
    
    $data = array (
      'where'=>$where,
      'order_by'=>$order_by
    );
     
    $data = $this->gcm_model->get_list($data)->body;
   
    return $data;
  }
  
  /***
   * Lay danh sach plan PD trong ngay ma chua xac nhan
   * 
   * 
   * **/
  public function alert_plan_pd() {
    $db = JBase::getDbo();
    $system_code = $this->system_code;
    
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d 23:59:59');
    
    $where = 'system_code = ' . $db->quote($system_code) . 
    ' AND (created_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')' .
    ' AND status = 0';
    
    $order_by ='created_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
     
    $data = $this->planpd_model
      ->get_all($data)
      ->body;
      
    if (empty($data->planpds)) {
      exit;
    } 
    $planpds = $data->planpds;
    
    $devices = $this->get_devices()->gcms;
    
    $title = 'Danh sách PD dự kiến ngày ' . date('Y-m-d');
    $content = array();
    
    foreach($planpds as $planpd) {
      $content []= $planpd->sponsor;
    }
    
    $content = implode(', ', $content);
    
    require_once PATH_COMPONENT . '/com_messagequeue/helper.php';
    require_once PATH_PLUGINS . '/uuid/uuid.php';
    
    $messageQueueHelper = new MessageQueueHelper($this->app, $this->system_code);
    
    foreach($devices as $device) {
      
      $data = array (
        'message_id' => str_replace('-', '', UUID::v4()),
        'title' => $title,
        'message' => $content,
        'status' => '0',
        'gcm_regid' => $device->gcm_regid,
        'system_code' => $this->system_code,
        'user_id' => $device->user_id,
        'type'=>1
      );
      $messageQueueHelper->insert_messagequeue($data);
    }
    
    echo 'Done';
  }


 /***
   * Lay danh sach PD cho di
   * 
   * 
   * **/
  public function alert_pd() {
    $db = JBase::getDbo();
    
    $system_code = $this->system_code;
    
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d 23:59:59');
    
    $where = 'system_code = ' . $db->quote($system_code) . 
    ' AND (created_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')' .
    ' AND  status = 0';
    
    $order_by ='created_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
     
    $data = $this->pdex_model
      ->get_all($data)
      ->body;
    
    if (empty($data->pds)) {
      exit;
    } 
    $title = 'Danh sách PD ' . date('Y-m-d');
    $content = array();
    
    foreach($data->pds as $pd) {
      $content []= $pd->sponsor;
    }
    
    $content = implode(', ', $content);
    $content = '<p><font color="red">Bạn cần vào M5 để chuyển tiền!</font></p><p>' . $content . '</p>';
    require_once PATH_COMPONENT . '/com_messagequeue/helper.php';
    require_once PATH_PLUGINS . '/uuid/uuid.php';
    
    $messageQueueHelper = new MessageQueueHelper($this->app, $this->system_code);
    
    $devices = $this->get_devices()->gcms;
    
    foreach($devices as $device) {
      
      $data = array (
        'message_id' => str_replace('-', '', UUID::v4()),
        'title' => $title,
        'message' => $content,
        'status' => '0',
        'gcm_regid' => $device->gcm_regid,
        'system_code' => $this->system_code,
        'user_id' => $device->user_id,
        'type'=>2
      );
      $messageQueueHelper->insert_messagequeue($data);
    }
    
    echo 'Done';
  }

/***
   * Lay danh sach plan_get
   * 
   * 
   * **/
  public function alert_plan_get() {
    $db = JBase::getDbo();
    
    $system_code = $this->system_code;
    
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d 23:59:59');
    
    $where = 'system_code = ' . $db->quote($system_code) . 
    ' AND (created_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')' .
    ' AND  status = 0';
    
    $order_by ='created_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
     
    $data = $this->planget_model
      ->get_all($data)
      ->body;
    if (empty($data->plangets)) {
      exit;
    }
    $title = 'Danh sách GET dự kiến ngày ' . date('Y-m-d');
    $content = array();
    
    foreach($data->plangets as $planget) {
      $content []= $planget->sponsor;
    }
    
    $content = implode(', ', $content);
    $content = '<p>Bạn cần vào M5 để đặt lệnh GET cho các mã sau:</p><p>' . $content . '</p>';
    require_once PATH_COMPONENT . '/com_messagequeue/helper.php';
    require_once PATH_PLUGINS . '/uuid/uuid.php';
    
    $messageQueueHelper = new MessageQueueHelper($this->app, $this->system_code);
    
    $devices = $this->get_devices()->gcms;
    
    foreach($devices as $device) {
      
      $data = array (
        'message_id' => str_replace('-', '', UUID::v4()),
        'title' => $title,
        'message' => $content,
        'status' => '0',
        'gcm_regid' => $device->gcm_regid,
        'system_code' => $this->system_code,
        'user_id' => $device->user_id,
        'type'=>3
      );
      $messageQueueHelper->insert_messagequeue($data);
    }
    
    echo 'Done';
  }

/***
   * Lay danh sach plan_get
   * 
   * 
   * **/
  public function alert_gd_approve() {
    $db = $this->app->getDbo();
    
    $system_code = $this->system_code;
    
    require_once  PATH_COMPONENT . '/com_jobs/helper.php';
    
    $helper = new JobsHelper($this->app, $system_code);
    
    $status = 2; // dang GD
    
    $meta = $helper->get_setting();
    
    $num_days_pd_pending = $meta->num_days_pd_pending;
    $num_days_pd_transfer = $meta->num_days_pd_transfer;
    $num_days_gd_pending = $meta->num_days_gd_pending;
    $num_days_gd_pending_verification = $meta->num_days_gd_pending_verification;
     
    $total = $num_days_pd_pending + $num_days_pd_transfer + $num_days_gd_pending + $num_days_gd_pending_verification;
    
    $current_time = time();
    $to_date = date('Y-m-d 23:59:59', strtotime('-'. ($total - 1) .' day', $current_time));
     
    $from_date = date('Y-m-d 00:00:00', strtotime('-'. $total .' day', $current_time));
     
    $where = 'system_code = ' . $db->quote($system_code) . 
      ' AND (issued_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')' .
      ' AND status=' . $db->quote($status);
    
    $order_by ='issued_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
       
    $data = $this->gd_model
      ->get_all($data)
      ->body;
    
    $title = 'Danh sách các mã cần xác nhận';
    $content = array();
    if (empty($data->gds)) {
      exit;
    }
    foreach($data->gds as $gd) {
      $content []= $gd->sponsor;
    }
    
    $content = implode(', ', $content);
    $content = '<p>Bạn cần vào M5 để xác nhận cho các mã sau:</p><p>' . $content . '</p>';
    require_once PATH_COMPONENT . '/com_messagequeue/helper.php';
    require_once PATH_PLUGINS . '/uuid/uuid.php';
    
    $messageQueueHelper = new MessageQueueHelper($this->app, $this->system_code);
    
    $devices = $this->get_devices()->gcms;
    
    foreach($devices as $device) {
      
      $data = array (
        'message_id' => str_replace('-', '', UUID::v4()),
        'title' => $title,
        'message' => $content,
        'status' => '0',
        'gcm_regid' => $device->gcm_regid,
        'system_code' => $this->system_code,
        'user_id' => $device->user_id,
        'type'=>4
      );
      $messageQueueHelper->insert_messagequeue($data);
    }
    
    echo 'Done';
  }
}
?>