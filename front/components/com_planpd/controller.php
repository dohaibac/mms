<?php
defined('BASEPATH') or die;

class PlanpdController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/planpd.php';
    require_once PATH_COMPONENT . '/com_pd/models/pd.php';
    require_once PATH_COMPONENT . '/com_setting/models/setting.php';
    require_once PATH_COMPONENT . '/com_sponsorinvest/models/sponsorinvest.php';
    
    $this->planpd_model =  new PlanpdModel($this->app);
    $this->pd_model =  new PdModel($this->app);
    $this->setting_model =  new SettingModel($this->app);
    $this->sponsorinvest_model =  new SponsorinvestModel($this->app);
  }

  public function get_all() {
    $this->app->prevent_remote_access();
    
    $db = JBase::getDbo();
    
    $system_code = $this->system_code();
    
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d 23:59:59');
    
    $where = 'system_code = ' . $db->quote($system_code) . 
    ' AND (created_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')';
    
    $order_by ='created_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by
    );
     
    $data = $this->planpd_model
      ->get_all($data)
      ->body;
     
    $data->from_date = $from_date;
    
    $this->renderJson($data);
  }
  
  public function auto_create_pd () {
    $this->app->prevent_remote_access();
    
    $list_required_fields = array(
      'sponsor', 'amount'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'pd-message-required_'. $field, $this->app->lang('pd-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
    $system_code = $this->system_code();
    
    $code = 'PD' . time();
    $sponsor = $this->getSafe('sponsor');
    $amount  = $this->getSafe('amount');
    
    $issued_at = date('Y-m-d h:i:s');
    
    $setting = $this->get_setting();

    $num_days_pending = $setting->num_days_pd_pending;
    $num_days_transfer = $setting->num_days_pd_transfer;
    
    $status = 1;// pending
    
    $data = array(
      'code' => $code,
      'sponsor' => $sponsor,
      'amount' =>$amount,
      'system_code' => $system_code,
      'issued_at' => $issued_at,
      'num_days_pending' => $num_days_pending,
      'num_days_transfer' => $num_days_transfer,
      'status' => $status,
      'auto_set' => 1,
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->pd_model->post($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0) {
      // update table plan_pd : updated_at and status
      $plan_pd = array(
        'sponsor' => $sponsor,
        'system_code' => $system_code,
        'status' => 1,
        'updated_at'=> date('Y-m-d h:i:s'),
        'updated_by'=>$this->app->user->data()->id
      );
      
     $ret = $this->planpd_model->put($plan_pd);
     
      // update updated_at trong table sponsor_invest
      $sponsor_invest = array(
        'sponsor' => $sponsor,
        'system_code' => $system_code,
        'updated_at'=> date('Y-m-d h:i:s'),
        'updated_by'=>$this->app->user->data()->id
      );
      
      $ret = $this->sponsorinvest_model->put($sponsor_invest);
    }
    
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }
  
  private function get_setting() {
    $data = array(
      'system_code' => $this->system_code()
    );
    
    $data = $this->setting_model->get($data)->body;
    
    $meta = json_decode($data->meta);
    
    $setting = new stdClass;
    
    $setting->id = $data->id;
    $setting->system_code = $data->system_code;
    
    foreach($meta as $key=>$val) {
      $setting->$key = $val;
    }
    
    return $setting;
  }
  
}
?>
