<?php
defined('BASEPATH') or die;

class BankController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/bank.php';
    
    $this->bank_model =  new BankModel($this->app);
  }

  public function get_list() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $db = $this->app->getDbo();
    
    $where = 'system_code=' . $db->quote($system_code);
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $order_by ='id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page
    );
     
    $result = $this->bank_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  
  public function edit() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $id = $this->getSafe('id');
    $name = $this->getSafe('name');
    $branch_name = $this->getSafe('branch_name');
    $account_hold_name = $this->getSafe('account_hold_name');
    $account_number = $this->getSafe('account_number');
    $linked_mobile_number = $this->getSafe('linked_mobile_number');
    
    if (empty($name)) {
      $ret = $this->message(1, 'bank-message-required_name', 'Required name.');
      $this->renderJson($ret);
    }
    
    if (empty($branch_name)) {
      $ret = $this->message(1, 'bank-message-required_branch', 'Required branch_name.');
      $this->renderJson($ret);
    }
    
    if (empty($account_hold_name)) {
      $ret = $this->message(1, 'bank-message-required_account_hold_name', 'Required account_hold_name.');
      $this->renderJson($ret);
    }
    
    if (empty($account_number)) {
      $ret = $this->message(1, 'bank-message-required_account_number', 'Required account_number.');
      $this->renderJson($ret);
    }
    
    if (empty($linked_mobile_number)) {
      $ret = $this->message(1, 'bank-message-required_linked_mobile_number', 'Required linked_mobile_number.');
      $this->renderJson($ret);
    }
    
    $data = array(
      'id' => $id,
      'name' => $name,
      'branch_name' => $branch_name,
      'account_hold_name' =>$account_hold_name,
      'account_number' =>$account_number,
      'system_code' => $system_code,
      'linked_mobile_number' => $linked_mobile_number,
      'updated_by' => $this->app->user->data()->id,
      'updated_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->bank_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  public function add() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $name = $this->getSafe('name');
    $branch_name = $this->getSafe('branch_name');
    $account_hold_name = $this->getSafe('account_hold_name');
    $account_number = $this->getSafe('account_number');
    $linked_mobile_number = $this->getSafe('linked_mobile_number');
    
    if (empty($name)) {
      $ret = $this->message(1, 'bank-message-required_name', 'Required name.');
      $this->renderJson($ret);
    }
    
    if (empty($branch_name)) {
      $ret = $this->message(1, 'bank-message-required_branch', 'Required branch_name.');
      $this->renderJson($ret);
    }
    
    if (empty($account_hold_name)) {
      $ret = $this->message(1, 'bank-message-required_account_hold_name', 'Required account_hold_name.');
      $this->renderJson($ret);
    }
    if (empty($account_number)) {
      $ret = $this->message(1, 'bank-message-required_account_number', 'Required account_number.');
      $this->renderJson($ret);
    }
    if (empty($linked_mobile_number)) {
      $ret = $this->message(1, 'bank-message-required_linked_mobile_number', 'Required linked_mobile_number.');
      $this->renderJson($ret);
    }
    
    $data = array(
      'name' => $name,
      'branch_name' => $branch_name,
      'account_hold_name' =>$account_hold_name,
      'account_number' =>$account_number,
      'system_code' => $system_code,
      'linked_mobile_number' => $linked_mobile_number,
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->bank_model->post($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  public function delete() {
    $this->app->prevent_remote_access();
    
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'bank-message-delete_required_id', 'Required id.');
      $this->renderJson($ret);
    }
    
    $system_code = $this->system_code();
    
    $data = array(
      'id'=> $id,
      'system_code' => $system_code
    );
    
    $result = $this->bank_model->delete($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
}
?>