<?php
defined('BASEPATH') or die;

class SettingController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/setting.php';
    
    $this->setting_model =  new SettingModel($this->app);
  }
  
  public function view() {
    $data = array(
      'system_code' => $this->system_code()
    );
    
    $result = $this->setting_model->get($data);
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'setting-message-' . $data->code, $this->app->lang('setting-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $meta = json_decode($data->meta);
    
    $setting = new stdClass;
    
    $setting->id = $data->id;
    $setting->system_code = $data->system_code;
    
    foreach($meta as $key=>$val) {
      $setting->$key = $val;
    }
    
    $this->renderJson($setting);
  }
  
  public function edit() {
    $this->app->prevent_remote_access();
     
    $list_required_fields = array(
      'num_days_pd_pending', 'num_days_pd_transfer', 'num_days_gd_pending', 'num_days_gd_pending_verification',
      'num_days_pd_next', 'percent_rate_days', 'percent_hoa_hong'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'setting-message-required_'. $field, $this->app->lang('setting-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
    $system_code = $this->system_code();
    
    $id = $this->getSafe('id');
    $num_commands_per_day = $this->getSafe('num_commands_per_day');
    $num_days_pd_pending = $this->getSafe('num_days_pd_pending');
    $num_days_pd_transfer = $this->getSafe('num_days_pd_transfer');
    $num_days_gd_pending = $this->getSafe('num_days_gd_pending');
    $num_days_gd_pending_verification = $this->getSafe('num_days_gd_pending_verification');
    $num_days_gd_approve = $this->getSafe('num_days_gd_approve');
    $num_days_pd_next = $this->getSafe('num_days_pd_next');
    $percent_rate_days = $this->getSafe('percent_rate_days');
    $percent_hoa_hong = $this->getSafe('percent_hoa_hong');
    
    $meta = array( 
      'num_commands_per_day' => $num_commands_per_day,
      'num_days_pd_pending' => $num_days_pd_pending,
      'num_days_pd_transfer' => $num_days_pd_transfer,
      'num_days_gd_pending' => $num_days_gd_pending,
      'num_days_gd_pending_verification' => $num_days_gd_pending_verification,
      'num_days_gd_approve' => $num_days_gd_approve,
      'num_days_pd_next' => $num_days_pd_next,
      'percent_rate_days' => $percent_rate_days,
      'percent_hoa_hong' => $percent_hoa_hong
    );
     
     $data = array(
      'id' => $id,
      'meta' => json_encode($meta),
      'system_code' => $system_code,
      'updated_by' => $this->app->user->data()->id,
      'updated_at' => date('Y-m-d h:i:s')
    );
    
    $result = $this->setting_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0) {
      require_once PATH_COMPONENT . '/com_jobs/helper.php';
      $jobs_heler = new JobsHelper($this->app, $this->system_code());
      
      $jobs_heler->create_plan_pd();
      
      $ret = $this->message(0, 'setting-message-insert_success', $this->app->lang('setting-message-insert_success'));
      $this->renderJson($ret);
    }
    else {
      $this->renderJson($data);
    } 
  }
  
  public function add() {
    $this->app->prevent_remote_access();
     
    $list_required_fields = array(
      'num_days_pd_pending', 'num_days_pd_transfer', 'num_days_gd_pending', 'num_days_gd_pending_verification',
      'num_days_pd_next', 'percent_rate_days', 'percent_hoa_hong'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'setting-message-required_'. $field, $this->app->lang('setting-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
    $system_code = $this->system_code();
    
    $num_commands_per_day = $this->getSafe('num_commands_per_day');
    $num_days_pd_pending = $this->getSafe('num_days_pd_pending');
    $num_days_pd_transfer = $this->getSafe('num_days_pd_transfer');
    $num_days_gd_pending = $this->getSafe('num_days_gd_pending');
    $num_days_gd_pending_verification = $this->getSafe('num_days_gd_pending_verification');
    $num_days_gd_approve = $this->getSafe('num_days_gd_approve');
    $num_days_pd_next = $this->getSafe('num_days_pd_next');
    $percent_rate_days = $this->getSafe('percent_rate_days');
    $percent_hoa_hong = $this->getSafe('percent_hoa_hong');
    
    $meta = array( 
      'num_commands_per_day' => $num_commands_per_day,
      'num_days_pd_pending' => $num_days_pd_pending,
      'num_days_pd_transfer' => $num_days_pd_transfer,
      'num_days_gd_pending' => $num_days_gd_pending,
      'num_days_gd_pending_verification' => $num_days_gd_pending_verification,
      'num_days_gd_approve' => $num_days_gd_approve,
      'num_days_pd_next' => $num_days_pd_next,
      'percent_rate_days' => $percent_rate_days,
      'percent_hoa_hong' => $percent_hoa_hong
    );
     
    $data = array(
      'meta' => json_encode($meta),
      'system_code' => $system_code,
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
    
    $result = $this->setting_model->post($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0) {
      $ret = $this->message(0, 'setting-message-insert_success', $this->app->lang('setting-message-insert_success'));
      $this->renderJson($ret);
    }
    else {
      $this->renderJson($data);
    } 
  }
  
}
?>