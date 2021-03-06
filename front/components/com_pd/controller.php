<?php
defined('BASEPATH') or die;

class PdController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/pd.php';
    require_once PATH_COMPONENT . '/com_sponsorinvest/models/sponsorinvest.php';
    
    $this->pd_model =  new PdModel($this->app);
    $this->sponsorinvest_model =  new SponsorinvestModel($this->app);
  }

  public function get_list() {
    $this->app->prevent_remote_access();
    
    // kiem tra xem user da co sponsor chua?
    if (empty($this->app->user->data()->sponsor_owner)) {
      $ret = $this->message(1, 'user-message-require_sponsor_owner', $this->app->lang('user-message-require_sponsor_owner'));
      $this->renderJson($ret);
    }
    
    $db = $this->app->getDbo();
    
    #require_once PATH_COMPONENT. '/com_sponsor/helper.php';
    
    #$sponsor_helper = new SponsorHelper($this->app);
    #$sponsors = $sponsor_helper->get_list();
    
    #$sponsors_array = $sponsor_helper->get_array($db, $sponsors->sponsors);
    
    #$sponsors_array_string = implode(',', $sponsors_array);
    
    $system_code = $this->system_code();
    $where = 'system_code = ' . $db->quote($system_code);
    
    $s_text = empty($this->data['s_text']) ? "" : $this->data['s_text'];
    
    if (!empty($s_text) and $s_text != ""){
      $s_text = '%' . $s_text . '%';  
      $where .= " and (code like " . $db->quote($s_text) . " or sponsor like " . $db->quote($s_text) . ")";
    }
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $page_size = empty($this->data['pageSize']) ? 1 : $this->data['pageSize'];
    $order_by ='issued_at ASC';
    
    $data = array(
      'sponsor_owner' => $this->app->user->data()->sponsor_owner,
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page,
      'limit' => $page_size
    );
     
    $result = $this->pd_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    foreach($data->pds as $pd) {
      $date =  new DateTime($pd->issued_at);
      $pd->issued_at_display = $date->format('Y-m-d');
    }
    $this->renderJson($data);
  }
  
  public function view () {
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'pd-message-require_id', $this->app->lang('pd-message-require_id'));
      $this->renderJson($ret);
    }
    
    $data = array(
      'id' => $id,
      'system_code' => $this->system_code()
    );
    
    $result = $this->pd_model->get($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'pd-message-' . $data->code, $this->app->lang('pd-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }
  
  public function add() {
    $this->app->prevent_remote_access();
    
    $list_required_fields = array(
      'sponsor', 'amount', 'issued_at', 'status'
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
    $remain_amount = "0";
    $issued_at = $this->getSafe('issued_at');
    
    $num_days_pending = '0';
    $num_days_transfer = '0';
    $status = $this->getSafe('status');
    
    $issued_at = $this->re_format_datetime($issued_at);
    
    $data = array(
      'code' => $code,
      'sponsor' => $sponsor['sponsor'],
      'amount' =>$amount,
      'bank_id' => '1',
      'remain_amount' =>$remain_amount,
      'system_code' => $system_code,
      'issued_at' => $issued_at,
      'num_days_pending' => $num_days_pending,
      'num_days_transfer' => $num_days_transfer,
      'status' => $body['status']['id'],
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    $data = $this->pd_model->post($data)->body;
    
    // update updated_at trong table sponsor_invest
      $sponsor_invest = array(
        'sponsor' => $sponsor['sponsor'],
        'system_code' => $system_code,
        'updated_at'=> date('Y-m-d h:i:s'),
        'updated_by'=>$this->app->user->data()->id
      );
      
      $ret = $this->sponsorinvest_model->put($sponsor_invest);
    
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }

  public function edit() {
    $this->app->prevent_remote_access();
    
    $list_required_fields = array(
      'id', 'code', 'sponsor', 'amount', 'issued_at', 'status'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'pd-message-required_'. $field, $this->app->lang('pd-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
    $system_code = $this->system_code();
    $id = $this->getSafe('id');
    $code = $this->getSafe('code');
    $sponsor = $this->getSafe('sponsor');
    $bank = $this->getSafe('bank');
    $amount  = $this->getSafe('amount');
    $remain_amount = $this->getSafe('remain_amount');
    $issued_at = $this->getSafe('issued_at');
    $num_days_pending = $this->getSafe('num_days_pending');
    $num_days_transfer = $this->getSafe('num_days_transfer');
    $status = $this->getSafe('status');
    
    $issued_at = $this->re_format_datetime($issued_at);
    
    $data = array(
      'id' => $id,
      'code' => $code,
      'sponsor' => $sponsor['sponsor'],
      'bank_id' => 1,
      'amount' =>$amount,
      'remain_amount' =>'0',
      'system_code' => $system_code,
      'issued_at' => $issued_at,
      'num_days_pending' => '0',
      'num_days_transfer' => '0',
      'status' => $body['status']['id'],
      'updated_by' => $this->app->user->data()->id,
      'updated_at' => date('Y-m-d h:i:s')
    );
     
    $data = $this->pd_model->put($data)->body;
    
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }
  
   public function update_status() {
    $this->app->prevent_remote_access();
    
    $list_required_fields = array(
      'id', 'status'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'pd-message-required_'. $field, $this->app->lang('pd-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
    $system_code = $this->system_code();
    $id = $this->getSafe('id');
    $status = $this->getSafe('status');
    $sponsor = $this->getSafe('sponsor');
    $amount = $this->getSafe('amount');
    
    $data = array(
      'id' => $id,
      'system_code' => $system_code,
      'status' => $status,
      'updated_by' => $this->app->user->data()->id,
      'updated_at' => date('Y-m-d h:i:s')
    );
     
    $data = $this->pd_model->put($data)->body;
    
    // xac nhan xong thi he thong tu dong tao GET luon
    if ($status == 3) {
      require_once PATH_COMPONENT . '/com_jobs/helper.php';
      $helper = new JobsHelper($this->app, $system_code);
      $helper->auto_create_plan_get($sponsor, $amount, $system_code);
    }
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }
  
  public function delete() {
    $this->app->prevent_remote_access();
    
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'pd-message-delete_required_id', 'Required id.');
      $this->renderJson($ret);
    }
    
    $system_code = $this->system_code();
    
    $data = array(
      'id'=> $id,
      'system_code' => $system_code
    );
    
    $result = $this->pd_model->delete($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }
  
  public function get_list_for_job() {
    
    $db = $this->app->getDbo();
    
    require_once PATH_COMPONENT. '/com_sponsor/helper.php';
    
    $sponsor_helper = new SponsorHelper($this->app);
    $sponsors = $sponsor_helper->get_list();
    
    $sponsors_array = $sponsor_helper->get_array($db, $sponsors->sponsors);
    
    $sponsors_array_string = implode(',', $sponsors_array);
    
    $system_code = $this->system_code();
    $where = 'system_code = ' . $db->quote($system_code) .  ' AND sponsor in ('. $sponsors_array_string .')';
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $order_by ='id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page
    );
     
    $result = $this->pd_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    return $data;
  }
  
  /***
    * Front controller of get status of PD 
    * 
    * */
  
  public function get_status() {
    $this->app->prevent_remote_access();
    
    $result = $this->pd_model->get_status();
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'pd-message-' . $data->code, $this->app->lang('pd-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }

  
  /****
   * Lay danh sach PD theo trang thai
   * 
   * */
  public function get_all_by_status () {
    $this->app->prevent_remote_access();
    
    $db = $this->app->getDbo();
    
    $system_code = $this->system_code();
    $status = $this->getSafe('status');
    
    $where = 'system_code = ' . $db->quote($system_code) . 
      ' AND status=' . $db->quote($status);
     
    $order_by ='issued_at ASC';
      
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
       
    $data = $this->pd_model
      ->get_all($data)
      ->body;
     
    $from_date = date('Y-m-d');
    $data->from_date = $from_date;
    
    if (isset($data->pds)) {
      foreach($data->pds as $pd) {
        $date =  new DateTime($pd->issued_at);
        $pd->issued_at_display = $date->format('Y-m-d');
      }
    }
    
    $this->renderJson($data);
  }
}
?>
