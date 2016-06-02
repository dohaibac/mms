<?php
defined('BASEPATH') or die;

class CandidateController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/candidate.php';
    
    $this->candidate_model =  new CandidateModel($this->app);
  }

  public function get_list() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $db = $this->app->getDbo();
    
    $where = 'system_code=' . $db->quote($system_code);
    $s_text = empty($this->data['s_text']) ? "" : $this->data['s_text'];
    $province_id = empty($this->data['province_id']) ? "" : $this->data['province_id'];
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $page_size = empty($this->data['pageSize']) ? 1 : $this->data['pageSize'];
    $order_by ='id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page,
      'limit' => $page_size,
      'keywords' => $s_text,
      'province_id' => $province_id
    );
     
    $result = $this->candidate_model->get_list($data);
    
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
    $email = $this->getSafe('email');
    $display_name = $this->getSafe('display_name');
    $mobile = $this->getSafe('mobile');
    $addr = $this->getSafe('addr');
    $notes = $this->getSafe('notes');
    
    $data = array(
      'id' => $id,
      'email' => $email,
      'display_name' => $display_name,
      'mobile' =>$mobile,
      'addr' =>$addr,
      'system_code' => $system_code,
      'notes' => $notes,
      'updated_by' => $this->app->user->data()->id,
      'updated_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->candidate_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  public function view() {
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'candidate-message-require_id', $this->app->lang('candidate-message-require_id'));
      $this->renderJson($ret);
    }
    
    $data = array(
      'id' => $id,
      'system_code' => $this->system_code()
    );
    
    $result = $this->candidate_model->get($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'candidate-message-' . $data->code, $this->app->lang('candidate-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }
  
  public function add() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $system_code = $this->system_code();
    
    $email = $this->getSafe('email');
    $display_name = $this->getSafe('display_name');
    $mobile = $this->getSafe('mobile');
    $addr = $this->getSafe('addr');
    $notes = $this->getSafe('notes');
    
    $data = array(
      'email' => $email,
      'display_name' => $display_name,
      'mobile' =>$mobile,
      'addr' =>$addr,
      'system_code' => $system_code,
      'notes' => $notes,
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
    
    $result = $this->candidate_model->post($data);
    
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
      $ret = $this->message(1, 'candidate-message-delete_required_id', 'Required id.');
      $this->renderJson($ret);
    }
    
    $system_code = $this->system_code();
    
    $data = array(
      'id'=> $id,
      'system_code' => $system_code
    );
    
    $result = $this->candidate_model->delete($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
}
?>
