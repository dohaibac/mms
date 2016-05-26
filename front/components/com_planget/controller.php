<?php
defined('BASEPATH') or die;

class PlangetController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/planget.php';
    require_once PATH_COMPONENT . '/com_pd/models/pd.php';
    require_once PATH_COMPONENT . '/com_setting/models/setting.php';
    require_once PATH_COMPONENT . '/com_sponsorinvest/models/sponsorinvest.php';
    
    $this->planget_model =  new PlangetModel($this->app);
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
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
     
    $data = $this->planget_model
      ->get_all($data)
      ->body;
     
    $data->from_date = $from_date;
    
    $this->renderJson($data);
  }
  
  public function auto_create_get () {
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
    
    $amount = $body['amount'];
    $id = $body['id'];
    $sponsor = $body['sponsor'];
    
    // update table plan_get : updated_at and status
    $plan_get = array(
      'id' => $id,
      'sponsor' => $sponsor,
      'system_code' => $system_code,
      'status' => 1,
      'updated_at'=> date('Y-m-d h:i:s'),
      'updated_by'=>$this->app->user->data()->id
    );
   
    $ret = $this->planget_model->put($plan_get);
    
    // add get vao table gds
    require_once PATH_COMPONENT . '/com_jobs/helper.php';
    
    $helper = new JobsHelper($this->app, $system_code);
    
    $data = $helper->auto_create_get($sponsor, $amount, $system_code);
    
    $data = $data->body;
    
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
