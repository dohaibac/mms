<?php
defined('BASEPATH') or die;

class UserdownlineController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/userdownline.php';
    require_once PATH_COMPONENT. '/com_sponsor/models/sponsor.php';
    require_once PATH_COMPONENT. '/com_user/models/user.php';
    require_once PATH_COMPONENT. '/com_systemcode/models/systemcode.php';
    require_once PATH_COMPONENT. '/com_group/models/group.php';
    
    $this->user_model =  new UserModel($this->app);
    $this->userdownline_model =  new UserdownlineModel($this->app);
    $this->sponsor_model =  new SponsorModel($this->app);
    $this->systemcode_model =  new SystemcodeModel($this->app);
  }
  
  public function view() {
    $id = $this->getSafe('id');
    $system_code = $this->getSafe('system_code');
    
    if (empty($id)) {
      $ret = $this->message(1, 'common-message-permission_denied_edit', $this->app->lang('common-message-permission_denied_edit'));
      $this->renderJson($ret);
    }
    
    $data = array(
      'id' => $id,
      'system_code' => $system_code
    );
    
    $result = $this->user_model->get($data);
    
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
  
  /***
   * Dang ky nguoi dung
   * 
   * 
   * */
  public function add () {
    $this->app->prevent_remote_access();
    
    $user_name  = $this->getSafe('user_name');
    $display_name  = $this->getSafe('display_name');
    $email      = $this->getSafe('email');
    $mobile     = $this->getSafe('mobile');
    $group_id   = 3;
    $password   = $this->getSafe('password');
    $repassword = $this->getSafe('repassword');
    $sponsor_owner = $this->getSafe('sponsor_owner');
    $block = $this->getSafe('block');
    
    $required_fields = array(
      'user_name', 'display_name', 'email', 'mobile', 'password', 'repassword'
    );
    
    $body = $this->get_request_body();
    
    foreach($required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'user-message-required_' . $field, $this->app->lang('user-message-required_input_' . $field));
        $this->renderJson($ret);
      }
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $ret = $this->message(1, 'common-message-email_invalid_format', $this->app->lang('common-message-email_invalid_format'));
      $this->renderJson($ret);
    }
    
    if ($password != $repassword) {
      $ret = $this->message(1, 'user-message-password_and_repassword_is_not_matched', $this->app->lang('user-message-password_and_repassword_is_not_matched'));
      $this->renderJson($ret);
    }
    
    $system_code = $this->app->user->data()->system_code;
    
    // kiem tra xem user_name da ton tai trong he thong chua?
    $result = $this->user_model->get_by_user_name(array ('user_name' => $user_name, 'system_code'=>$system_code));
     
    $data = $result->body;
    
    if ($data->type == 0 ) {
      $ret = $this->message(1, 'user-message-user_name_already_exist', $this->app->lang('user-message-user_name_already_exist'));
      $this->renderJson($ret);
    }

    // kiem tra xem email da ton tai trong he thong chua?
    $result = $this->user_model->get_by_email(array ('email' => $email, 'system_code'=>$system_code));
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_get_failed', $this->app->lang('common-message-api_get_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0 ) {
      $ret = $this->message(1, 'user-message-email_already_exist', $this->app->lang('user-message-email_already_exist'));
      $this->renderJson($ret);
    }
    
    // lay system_code
    $ret = $this->systemcode_model->get_latest(array())->body;
    
    if (isset($ret->type) && $ret->type == 1) {
      $this->renderJson($ret);
    }
    
    $systemcode = intval($ret->code) + 1;
    $new_system_code = add_zero_in_single_number($systemcode);
    
    // update new systemcode
    $this->systemcode_model->post(array('code'=>$new_system_code));
    
    // tao group
    require_once PATH_COMPONENT . '/com_group/helper.php';
    $group_helper = new GroupHelper($this->app);
    
    $new_group = $group_helper->add(array(
      'name' => 'Manager',
      'ord' => '1',
      'description' => 'Nhóm quản lý',
      'block' => 0,
      'system_code' => $new_system_code
    ));
    
    $group_id = $new_group->body->data->group_id;
    
    $group_helper->add(array(
      'name' => 'User',
      'ord' => '1',
      'description' => 'Nhóm người dùng',
      'block' => 0,
      'system_code' => $new_system_code
    ));
    
    // chua ton tai thi tao user
    $user = array (
      'display_name'=> $display_name,
      "user_name" => $user_name,
      "email" => $email,
      'password'=> $password,
      'group_id' => $group_id, 
      'mobile'=> $mobile, 
      'sponsor_owner'=> $sponsor_owner,
      'user_type'=> 2,
      'block'=>$block,
      'system_code'=> $new_system_code,
      'email_confirmed' => 1,
      'created_at'=>date('Y-m-d h:i:s'),
      'created_by'=> $this->app->user->data()->id
    );
    
    $result = $this->user_model->post($user);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    // tao table tuong ung theo $new_system_code
    require_once PATH_COMPONENT . '/com_userdownline/helper.php';
    $helper = new UserdownlineHelper($this->app);
    $helper->create_table_by_new_system_code($new_system_code);
    
    $data = $result->body;
    
    if ($data->type == 0) {
      $ret = $this->message(0, 'user-message-register_downline_success', $this->app->lang('user-message-register_downline_success'));
      $this->renderJson($ret);
    }
    
    $ret = $this->message($data->type, 'register-message-' . $data->code, $this->app->lang('register-message-' . $data->code));
    
    $this->renderJson($ret);
  }
  
  /***
   * Dang ky nguoi dung
   * 
   * 
   * */
  public function edit () {
    $this->app->prevent_remote_access();
    
    $display_name = $this->getSafe('display_name');
    $email      = $this->getSafe('email');
    $mobile     = $this->getSafe('mobile');
   
    $password   = $this->getSafe('password');
    $repassword = $this->getSafe('repassword');
    $sponsor_owner = $this->getSafe('sponsor_owner');
    $system_code = $this->getSafe('system_code');
    $group_id = $this->getSafe('group_id');
    
    $block = $this->getSafe('block');
    
    if (empty($display_name)) {
      $ret = $this->message(1, 'user-message-required_display_name', $this->app->lang('user-message-required_input_display_name'));
      $this->renderJson($ret);
    }
    if (empty($email)) {
      $ret = $this->message(1, 'common-message-required_email', $this->app->lang('common-message-required_input_email'));
      $this->renderJson($ret);
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $ret = $this->message(1, 'common-message-email_invalid_format', $this->app->lang('common-message-email_invalid_format'));
      $this->renderJson($ret);
    }
    
    if (empty($mobile)) {
      $ret = $this->message(1, 'user-message-required_mobile', $this->app->lang('user-message-required_input_mobile'));
      $this->renderJson($ret);
    }
    
    if (!empty($password) && empty($repassword)) {
      $ret = $this->message(1, 'user-message-required_repassword', $this->app->lang('user-message-required_input_repassword'));
      $this->renderJson($ret);
    }
    
    if (!empty($password) && $password != $repassword) {
      $ret = $this->message(1, 'user-message-password_and_repassword_is_not_matched', $this->app->lang('user-message-password_and_repassword_is_not_matched'));
      $this->renderJson($ret);
    }
      
    $user = array (
      'display_name'=> $display_name,
      'email'=> $email,
      'group_id' => $group_id, 
      'mobile'=> $mobile,
      'sponsor_owner'=> $sponsor_owner,
      'system_code'=> $system_code,
      'block'=> $block,
      'updated_at'=>date('Y-m-d h:i:s'),
      'updated_by'=> $this->app->user->data()->id
    );
    
    if (!empty($password)) {
      $user['password'] = $password;
    }
    
    $result = $this->user_model->put($user);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0) {
      $ret = $this->message(0, 'user-message-update_success', $this->app->lang('user-message-update_success'));
      $this->renderJson($ret);
    }
    
    $ret = $this->message($data->type, 'user-message-' . $data->code, $this->app->lang('user-message-' . $data->code));
    
    $this->renderJson($ret);
  }
  
  public function delete() {
    $this->app->prevent_remote_access();
    
    $id = $this->getSafe('id');
    
    $user_id = $this->app->user->data()->id;
    
    if ($id == $user_id) {
      $ret = $this->message(1, 'user-message-can_not_delete_your_self', $this->app->lang('user-message-can_not_delete_your_self'));
      $this->renderJson($ret);
    }
    
    $system_code = $this->system_code();
    
    $data = array (
      'id'=> $id,
      'system_code' => $system_code
    );
    
    $result = $this->user_model->delete($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  public function get_list() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $db = $this->app->getDbo();
    
    $where = 'user_type=2';
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $order_by ='id DESC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page
    );
     
    $result = $this->user_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    $this->renderJson($data);
  }
}
?>