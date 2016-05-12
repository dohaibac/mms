<?php
defined('BASEPATH') or die;

class SponsorController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/sponsor.php';
    require_once PATH_COMPONENT . '/com_bank/models/bank.php';
    
    $this->sponsor_model =  new SponsorModel($this->app);
    $this->bank_model =  new BankModel($this->app);
  }
  
  /***
   * Kiem tra xem sponsor da ton tai hay khong
   * 
   * */
  public function get_check_by_username() {
    $this->app->prevent_remote_access();
    
    $username = $this->getSafe('username');
    $data = array('username'=>$username);
     
    $result = $this->sponsor_model->get_by_username($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (empty($data->data) || empty($data->data->id)) {
      $ret = $this->message(1, 'sponsor-message-get_check_by_username_not_found', $this->app->lang('sponsor-message-get_check_by_username_not_found'));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }
  
  public function get_list() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $db = $this->app->getDbo();
    
    // get sponsor
    $sponsor = $this->sponsor_model->get_by_username(array('username' => $this->app->user->data()->sponsor_owner));
   
    $data = $sponsor->body;
    
    if (empty($data->data) || empty($data->data->id)) {
      $ret = $this->message(1, 'sponsor-message-get_list_not_found_sponsor_owner', $this->app->lang('sponsor-message-get_list_not_found_sponsor_owner'));
      $this->renderJson($ret);
    }
    
    $data = $data->data;
    $path = $data->path;
    
    $where = 'path LIKE \''. $path .'%\'';
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $order_by ='level, id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page,
      'limit' => 50000000
    );
     
    $result = $this->sponsor_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    $data->sponsor_owner = $this->app->user->data()->sponsor_owner;
    $data->group_id = $this->app->user->data()->group_id;
    
    $this->renderJson($data);
  }
  
  public function search() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $db = $this->app->getDbo();
    
    $keyword = $this->getSafe('keyword');
    
    // get sponsor
    $sponsor = $this->sponsor_model->get_by_username(array('username' => $keyword));
   
    $data = $sponsor->body;
    
    if (empty($data->data) || empty($data->data->id)) {
      $ret = $this->message(1, 'sponsor-message-search_not_found', $this->app->lang('sponsor-message-search_not_found'));
      $this->renderJson($ret);
    }
    
    $data = $data->data;
    $path = $data->path;
    
    $where = 'path LIKE \''. $path .'%\'';
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $order_by ='level, id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page,
      'limit' => 50000000
    );
     
    $result = $this->sponsor_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    $data->sponsor_owner = $keyword;
    $data->group_id = $this->app->user->data()->group_id;
    
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
      $ret = $this->message(1, 'sponsor-message-required_name', 'Required name.');
      $this->renderJson($ret);
    }
    
    if (empty($branch_name)) {
      $ret = $this->message(1, 'sponsor-message-required_branch', 'Required branch_name.');
      $this->renderJson($ret);
    }
    
    if (empty($account_hold_name)) {
      $ret = $this->message(1, 'sponsor-message-required_account_hold_name', 'Required account_hold_name.');
      $this->renderJson($ret);
    }
    
    if (empty($account_number)) {
      $ret = $this->message(1, 'sponsor-message-required_account_number', 'Required account_number.');
      $this->renderJson($ret);
    }
    
    if (empty($linked_mobile_number)) {
      $ret = $this->message(1, 'sponsor-message-required_linked_mobile_number', 'Required linked_mobile_number.');
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
     
    $result = $this->sponsor_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  private function validate_input_data() {
    $name = $this->getSafe('name');
    $user_name = $this->getSafe('username');
    $email = $this->getSafe('email');
    $mobile = $this->getSafe('mobile');
    $bank = $this->getSafe('bank');
    
    if (empty($name)) {
      $ret = $this->message(1, 'sponsor-message-required_name', $this->app->lang('sponsor-message-required_name'));
      $this->renderJson($ret);
    }
    if (empty($user_name)) {
      $ret = $this->message(1, 'sponsor-message-required_username', $this->app->lang('sponsor-message-required_username'));
      $this->renderJson($ret);
    }
    
    if (empty($email)) {
      $ret = $this->message(1, 'sponsor-message-required_email', $this->app->lang('sponsor-message-required_email'));
      $this->renderJson($ret);
    }
    
    if (empty($mobile)) {
      $ret = $this->message(1, 'sponsor-message-required_mobile', $this->app->lang('sponsor-message-required_mobile'));
      $this->renderJson($ret);
    }
    
    if (empty($bank['id'])) {
      $ret = $this->message(1, 'sponsor-message-empty_banks', $this->app->lang('sponsor-message-empty_banks'));
      $this->renderJson($ret);
    }
  }
  
  private function get_upline_level_and_path($upline, $system_code) {
    // kiem tra xem da co' root chua, neu chua thi no' se la root
    $data = array(
      'system_code' => $system_code
    );
    
    $level = -1;
    $path = '';
    
    $sponsor_top_one = $this->sponsor_model->get_top_one($data);
    
    $data = $sponsor_top_one->body;
    
    if ($data->type == 1) {
      $ret = $this->message(1, 'sponsor-message-' .$data->code, $this->app->lang('sponsor-message-'. $data->code));
      $this->renderJson($ret);
    }
    
    $data = $data->data;
    
    if (empty($data) || empty($data->id)) { // chua ton tai sponsor
      if (!empty($upline)) {
        $ret = $this->message(1, 'sponsor-message-upline_should_empty', $this->app->lang('sponsor-message-upline_should_empty'));
        $this->renderJson($ret);
      }
      $level = -1;
    }
    else {
      if (empty($upline)) {
        $ret = $this->message(1, 'sponsor-message-required_upline', $this->app->lang('sponsor-message-required_upline'));
        $this->renderJson($ret);
      }
      
      // get upline
      $upline = $this->sponsor_model->get_by_username(array('username'=>$upline));
      
      $data = $upline->body;
      
      if ($data->type == 1) {
        $ret = $this->message(1, 'sponsor-message-' .$data->code, $this->app->lang('sponsor-message-'. $data->code));
        $this->renderJson($ret);
      }
      
      if (empty($data->data) || empty($data->data->id)) {
        $ret = $this->message(1, 'sponsor-message-upline_does_not_exist', $this->app->lang('sponsor-message-upline_does_not_exist'));
        $this->renderJson($ret);
      }
      $path = $data->data->path;
      $level = $data->data->level;
    }
    
    $obj = new stdClass;
    $obj->level = $level;
    $obj->path = $path;
    
    return $obj;
  
  }

  private function warning_max_downline_f1($force_downline_f1) {
    if ($force_downline_f1) {
      return false;
    }
    $upline = $this->getSafe('upline');
    // canh bao da du 5 nhanh
    $downlines = $this->sponsor_model->get_downline_f1(array('upline'=>$upline));
    
    $downlines = $downlines->body;
    
    if ($downlines->type == 1) {
       $ret = $this->message(1, 'sponsor-message-' .$downlines->code, $this->app->lang('sponsor-message-'. $downlines->code));
       $this->renderJson($ret);
    }
    
    if (count($downlines->data) >= 5) {
       $ret = $this->message(1, 'sponsor-message-max_downline', sprintf($this->app->lang('sponsor-message-max_downline'), $upline));
       $this->renderJson($ret);
    }
  }
  
  private function warning_max_downline_fork($force_downline_fork) {
    if ($force_downline_fork) {
      return false;
    }
    $upline = $this->getSafe('upline');
    
    // canh bao phat trien du 3 nhanh
    $upline = $this->sponsor_model->get_upline(array('username' =>$upline));
   
    $upline = $upline->body->data;
    
    // tinh xem co bao nhieu thang ben duoi da phat trien nhanh, va bao nhieu nhanh da phat trien
    $downlines = $this->sponsor_model->get_downline_f1(array('upline' => $upline->username));
    
    $downlines = $downlines->body;
    
    if ($downlines->type == 1) {
      $ret = $this->message(1, 'sponsor-message-'. $downlines->code, $this->app->lang('sponsor-message-'. $downlines->code));
      $this->renderJson($ret);
    }
    
    $total_fork = 0;
    foreach($downlines->data as $downline) {
      if ($downline->has_fork) {
        $total_fork++;
      }
    }
    
    if ($total_fork >=3) {
      $ret = $this->message(1, 'sponsor-message-max_fork', sprintf($this->app->lang('sponsor-message-max_fork'), $this->getSafe('upline')));
      $this->renderJson($ret);
    }
  }
  
  public function add() {
    $this->app->prevent_remote_access();
    $system_code = $this->system_code();
    
    $this->validate_input_data();
    
    $upline = $this->getSafe('upline');
    
    $level_and_path = $this->get_upline_level_and_path($upline, $system_code);
    
    $level = $level_and_path->level;
    $path  = $level_and_path->path;
    
    if ($level > -1) {
      $force_downline_f1 = $this->getSafe('force_downline_f1');
      $this->warning_max_downline_f1($force_downline_f1);
      
    }
    
    if ($level > 0) {
      $force_downline_fork = $this->getSafe('force_downline_fork');
      $this->warning_max_downline_fork($force_downline_fork);      
    }
    
    $sponsor = array();
    
    $sponsor['name'] = $this->getSafe('name');
    $sponsor['username'] = $this->getSafe('username');
    $sponsor['upline'] = $this->getSafe('upline');
    $sponsor['email'] = $this->getSafe('email');
    $sponsor['mobile'] = $this->getSafe('mobile');
    $sponsor['level'] = $level + 1;
    $sponsor['path'] = $path . $this->getSafe('username') . '>';
    $sponsor['system_code'] = $system_code;
    $sponsor['created_at'] = date('Y-m-d h:i:s');
    $sponsor['created_by'] = $this->app->user->data()->id;
    
    $ret = $this->sponsor_model->post($sponsor);
    
    $ret = $ret->body;
    
    if ($ret->type == 1) {
      $ret = $this->message(1, 'sponsor-message-' .$ret->code, $this->app->lang('sponsor-message-'. $ret->code));
      $this->renderJson($ret);
    }
    
    $sponsor_inserted_id = $ret->data->sponsor_id;
   
    // update has fork
    $ret = $this->sponsor_model->update_has_fork(array('username'=>$sponsor['upline'], 'has_fork'=> true, 'system_code'=>$system_code));
    
    $ret = $this->message(0, 'sponsor-message-insert_success', $this->app->lang('sponsor-message-insert_success'));
    $this->renderJson($ret);
  }
  
  public function delete() {
    $this->app->prevent_remote_access();
    
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'sponsor-message-delete_required_id', 'Required id.');
      $this->renderJson($ret);
    }
    
    $system_code = $this->system_code();
    
    $data = array(
      'id'=> $id,
      'system_code' => $system_code
    );
    
    $result = $this->sponsor_model->delete($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  public function get_sponsor_owner() {
    $ret = array(
      'sponsor_owner' => $this->app->user->data()->sponsor_owner
    );
    
    $this->renderJson($ret);
  }
}

?>