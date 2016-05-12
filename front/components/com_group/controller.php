<?php
defined('BASEPATH') or die;

class GroupController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/group.php';
    
    $this->group_model =  new GroupModel($this->app);
  }

  public function get_list() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $db = $this->app->getDbo();
    
    $where = 'system_code=' . $db->quote($system_code);
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $order_by ='ord, id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page
    );
     
    $result = $this->group_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    $data->is_supper_group = $this->app->user->data()->group_id == 1;
    $this->renderJson($data);
  }
  
  public function view() {
    $group_id = $this->getSafe('group_id');
    
    if (empty($group_id)) {
      $ret = $this->message(1, 'common-message-permission_denied_edit', $this->app->lang('common-message-permission_denied_edit'));
      $this->renderJson($ret);
    }
    
    $data = array(
      'id' => $group_id,
      'system_code' => $this->system_code()
    );
    
    $result = $this->group_model->get($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'group-message-' . $data->code, $this->app->lang('group-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }
  public function edit() {
    $this->app->prevent_remote_access();
    
    $id = $this->getSafe('id');
    
    $name = $this->getSafe('name');
    $ord  = $this->getSafe('ord');
    $description = $this->getSafe('description');
    $system_code = $this->getSafe('system_code');
    $block = $this->getSafe('block');
    
    //TODO:: validate
    
    $data = array(
      'id'=> $id,
      'name'=> $name,
      'ord'=> $ord,
      'description'=> $description,
      'system_code' => $system_code,
      'block'=> $block,
      'updated_at'=>date('Y-m-d h:i:s'),
      'updated_by'=> $this->app->user->data()->id,
    );
     
    $result = $this->group_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, 'group-message-' . $data->code, $this->app->lang('group-message-'. $data->code));
    $this->renderJson($ret);
  }
  
  public function add() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $name = $this->getSafe('name');
    $ord = $this->getSafe('ord', 0);
    $description = $this->getSafe('description');
    $block = $this->getSafe('block');
    
    $data = array(
      'name' => $name,
      'ord' => $ord,
      'description' =>$description,
      'block' =>$block,
      'system_code' => $system_code,
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->group_model->post($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  public function delete() {
    $this->app->prevent_remote_access();
    
    $id = $this->getSafe('group_id');
    $system_code = $this->system_code();
    
    // kiem tra xem nhom da co nguoi dung chua?
    // neu co roi thi khong duoc xoa
    require_once PATH_COMPONENT . '/com_user/models/user.php';
    
    $this->user_model =  new UserModel($this->app);
    
    $users = $this->user_model->get_by_group_id(array('group_id' => $id, 'system_code'=>$system_code));
    
    $body = $users->body;
    
    if (!empty($body->users)) {
      $ret = $this->message(1, 'group-message-can_not_delete_group_because_exist_users', $this->app->lang('group-message-can_not_delete_group_because_exist_users'));
      $this->renderJson($ret);
    }
    
    $data = array(
      'id'=> $id,
      'system_code' => $system_code
    );
    
    $result = $this->group_model->delete($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
}
?>