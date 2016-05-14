<?php
defined('BASEPATH') or die;

class GdController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/gd.php';
    
    $this->gd_model =  new GdModel($this->app);
  }

  public function get_list() {
    $this->app->prevent_remote_access();
    
    // kiem tra xem user da co sponsor chua?
    if (empty($this->app->user->data()->sponsor_owner)) {
      $ret = $this->message(1, 'user-message-require_sponsor_owner', $this->app->lang('user-message-require_sponsor_owner'));
      $this->renderJson($ret);
    }
    
    $db = $this->app->getDbo();
    
    require_once PATH_COMPONENT. '/com_sponsor/helper.php';
    
    $sponsor_helper = new SponsorHelper($this->app);
    $sponsors = $sponsor_helper->get_list();
    
    $sponsors_array = $sponsor_helper->get_array($db, $sponsors->sponsors);
    
    $sponsors_array_string = implode(',', $sponsors_array);
    
    $system_code = $this->system_code();
    $where = 'system_code = ' . $db->quote($system_code) .  ' AND sponsor in ('. $sponsors_array_string .')';
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $page_size = empty($this->data['pageSize']) ? 1 : $this->data['pageSize'];
    $order_by ='id';
    
    $data = array(
      'where' => $where,
      'order_by' => $order_by,
      'page_number' => $current_page,
      'limit' => $page_size
    );
     
    $result = $this->gd_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    foreach($data->gds as $gd) {
      $date =  new DateTime($gd->issued_at);
      $gd->issued_at_display = $date->format('Y-m-d');
    }
    $this->renderJson($data);
  }
  
  public function view() {
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'gd-message-require_id', $this->app->lang('gd-message-require_id'));
      $this->renderJson($ret);
    }
    
    $data = array(
      'id' => $id,
      'system_code' => $this->system_code()
    );
    
    $result = $this->gd_model->get($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'gd-message-' . $data->code, $this->app->lang('gd-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }
  
  public function add() {
    $this->app->prevent_remote_access();
    
    $list_required_fields = array(
      'code', 'sponsor', 'amount', 'wallet', 'issued_at', 'num_hours_gd_approve', 'status'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'gd-message-required_'. $field, $this->app->lang('gd-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
    $system_code = $this->system_code();
    
    $code = $this->getSafe('code');
    $sponsor = $this->getSafe('sponsor');
    $amount  = $this->getSafe('amount');
    $wallet = $this->getSafe('wallet');
    $bank = $this->getSafe('bank');
    $issued_at = $this->getSafe('issued_at');
    $num_hours_gd_approve = $this->getSafe('num_hours_gd_approve');
    $status = $this->getSafe('status');
    
    $issued_at = $this->re_format_datetime($issued_at);
    
    $data = array(
      'code' => $code,
      'sponsor' => $sponsor['username'],
      'bank_id' => $bank['id'],
      'amount' =>$amount,
      'wallet' =>$wallet,
      'system_code' => $system_code,
      'issued_at' => $issued_at,
      'num_hours_gd_approve' => $num_hours_gd_approve,
      'status' => $body['status']['id'],
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->gd_model->post($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }

  public function edit() {
    $this->app->prevent_remote_access();
    
    $list_required_fields = array(
      'id', 'code', 'sponsor', 'amount', 'wallet', 'issued_at', 'num_hours_gd_approve', 'status'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'gd-message-required_'. $field, $this->app->lang('gd-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
    $system_code = $this->system_code();
    $id = $this->getSafe('id');
    $code = $this->getSafe('code');
    $sponsor = $this->getSafe('sponsor');
    $bank = $this->getSafe('bank');
    $amount  = $this->getSafe('amount');
    $wallet = $this->getSafe('wallet');
    $issued_at = $this->getSafe('issued_at');
    $num_hours_gd_approve = $this->getSafe('num_hours_gd_approve');
    $status = $this->getSafe('status');
    
    $issued_at = $this->re_format_datetime($issued_at);
    
    $data = array(
      'id' => $id,
      'code' => $code,
      'sponsor' => $sponsor['username'],
      'bank_id' => $bank['id'],
      'amount' =>$amount,
      'wallet' =>$wallet,
      'system_code' => $system_code,
      'issued_at' => $issued_at,
      'num_hours_gd_approve' => $num_hours_gd_approve,
      'status' => $body['status']['id'],
      'updated_by' => $this->app->user->data()->id,
      'updated_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->gd_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }
  
  public function delete() {
    $this->app->prevent_remote_access();
    
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'gd-message-delete_required_id', 'Required id.');
      $this->renderJson($ret);
    }
    
    $system_code = $this->system_code();
    
    $data = array(
      'id'=> $id,
      'system_code' => $system_code
    );
    
    $result = $this->gd_model->delete($data);
    
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
     
    $result = $this->gd_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    return $data;
  }
}
?>
