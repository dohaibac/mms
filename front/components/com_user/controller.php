<?php
defined('BASEPATH') or die;

class UserController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/user.php';
    require_once PATH_COMPONENT. '/com_sponsor/models/sponsor.php';
    
    $this->user_model =  new UserModel($this->app);
    $this->sponsor_model =  new SponsorModel($this->app);
  }
  
  /***
   * Type Ajax
   * 
   * */
  public function login() {
    $this->app->prevent_remote_access();
    
    $email = trim($this->getSafe('email'));
    $password = $this->getSafe('password');
    $system_code = $this->getSafe('system_code');
    
    if (empty($system_code)) {
      $system_code = $this->app->appConf->default_system_code;
    }
    
    if (empty($email)) {
      $ret = $this->message(1, 'login-message-required_input_email', $this->app->lang('login-message-required_input_email'));
      $this->renderJson($ret);
    }
    
    if (empty($password)) {
      $ret = $this->message(1, 'login-message-required_input_password', $this->app->lang('login-message-required_input_password'));
      $this->renderJson($ret);
    }
    
    // lay thong tin theo email
    $result = $this->user_model->get(array ('email' => $email, 'system_code' => $system_code, 'include_password' => true));
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'login-message-api_check_failed', $this->app->lang('login-message-api_check_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0 ) {
      $user = $data->user;
      
      // kiem tra xem user co bi block khong?
      if ($user->block) {
        $ret = $this->message(1, 'login-message-user_is_blocked', $this->app->lang('login-message-user_is_blocked'));
        $this->renderJson($ret);
      }
      
      $current_password = $user->password;
      
      // check xem co match password khong?
      require_once PATH_PLUGINS . '/hash/crypt.php';
      
      $hash = new HashPassword();
      
      if ($hash->verify($password, $current_password)) {// matched
        unset($data->user->password);
        // set session
        $session = JBASE::getSession();
        
        $session->set('user', $data->user);
        
        $from = $this->getSafe('from', '');
        
        if (empty($from)) {
          $from = $this->app->lang('common-url-dashboard');
        }
        
        $ret = $this->message(0, 'login-message-success', $this->app->lang('login-message-success'));
        $ret['from'] = $from;
        
        $this->renderJson($ret);
      } else {
        $ret = $this->message(1, 'login-message-user_view_not_found', $this->app->lang('login-message-password_not_matched'));
        $this->renderJson($ret);
      }
    } else {
      $ret = $this->message(1, 'login-message-' . $data->code, $this->app->lang('login-message-' . $data->code));
      $this->renderJson($ret);
    }
  }
  
  public function logout() {
    $session = JBase::getSession();
    
    $session->clear('user');
    $session->clear('group');
    
    //$ret = $this->message(0, 'message-logout_success', $this->app->lang('message-logout_success'));
    //$this->renderJson($ret);
    $this->redirect($this->app->base_url . '/' . $this->app->lang('common-url-login'));
  }
  
  /***
   * cap nhat user
   * 
   * */
  public function update () {
    $this->app->prevent_remote_access();
    
    $this->check_ajax_required_login();
     
    $email = $this->getSafe('email');
    $display_name = $this->getSafe('display_name');
    $mobile = $this->getSafe('mobile'); 
    $phone = $this->getSafe('phone');
    $addr = $this->getSafe('addr');
    
    $user = array (
      'email' => $email,
      'display_name' => $display_name,
      'mobile' => $mobile,
      'phone' => $phone,
      'addr' => $addr,
      'updated_at'=>date('Y-m-d h:i:s'),
      'updated_by'=>$this->app->user->data()->id 
    );
    
    $result = $this->user_model->put($user);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, 'profile-message-' . $data->code, $this->app->lang('profile-message-' . $data->code));
    
    if ($data->type == 0) {
      $ret['user'] = $user;
      $user_session = $this->app->user->data();
      $user_session->email = $user['email'];
      $user_session->display_name = $user['display_name'];
      $user_session->mobile = $user['mobile'];
      $user_session->phone = $user['phone'];
      $user_session->addr = $user['addr'];
    }
    
    $this->renderJson($ret);
  }

  /***
   * change password
   * 
   * */
  public function change_password () {
    $this->app->prevent_remote_access();
    $this->check_ajax_required_login();
     
    $password_old = $this->getSafe('password_old');
    $password_new = $this->getSafe('password_new');
    $password_renew = $this->getSafe('password_renew'); 
    
    if (empty($password_old)) {
      $ret = $this->message(1, 'change_password-message-required_password_old', $this->app->lang('change_password-message-required_password_old'));
      $this->renderJson($ret);
    }
    if (empty($password_new)) {
      $ret = $this->message(1, 'change_password-message-required_password_new', $this->app->lang('change_password-message-required_password_new'));
      $this->renderJson($ret);
    }
    if (empty($password_renew)) {
      $ret = $this->message(1, 'change_password-message-required_password_renew', $this->app->lang('change_password-message-required_password_renew'));
      $this->renderJson($ret);
    }
    if ($password_new != $password_renew) {
      $ret = $this->message(1, 'change_password-message-password_new_and_password_renew_is_not_matched', $this->app->lang('change_password-message-password_new_and_password_renew_is_not_matched'));
      $this->renderJson($ret);
    }
    
    
    $email = $this->app->user->data()->email;
    
    // kiem tra xem mat khau cu co match khong?
    $result = $this->user_model->get(array ('email' => $email, 'include_password' => true));
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'login-message-api_check_failed', $this->app->lang('login-message-api_check_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0 ) {
      $user = $data->user;
      
      $current_password = $user->password;
      
      // check xem co match password khong?
      require_once PATH_PLUGINS . '/hash/crypt.php';
      
      $hash = new HashPassword();
      
      if (!$hash->verify($password_old, $current_password)) {
        $ret = $this->message(1, 'change_password-message-password_old_not_right', $this->app->lang('change_password-message-password_old_not_right'));
        $this->renderJson($ret);
      }
    }
    
    $user = array (
      'email' => $email,
      'password' => $password_new,
      'updated_at'=>date('Y-m-d h:i:s'),
      'updated_by'=>$this->app->user->data()->id 
    );
    
    $result = $this->user_model->put($user);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, 'change_password-message-' . $data->code, $this->app->lang('change_password-message-' . $data->code));
    
    $this->renderJson($ret);
  }
 
  /***
   * forgot password
   * 
   * */
  public function forgot_password () {
    $this->app->prevent_remote_access();
    
    $email = $this->getSafe('email');
    $captcha = $this->getSafe('captcha');
    if (empty($email)) {
      $ret = $this->message(1, 'forgot_password-message-required_input_email', $this->app->lang('forgot_password-message-required_input_email'));
      $this->renderJson($ret);
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $ret = $this->message(1, 'forgot_password-message-email_invalid_format', $this->app->lang('forgot_password-message-email_invalid_format'));
      $this->renderJson($ret);
    }
    
    if (empty($captcha)) {
      $ret = $this->message(1, 'forgot_password-message-required_input_captcha', $this->app->lang('forgot_password-message-required_input_captcha'));
      $this->renderJson($ret);
    }
    
    // kiem tra xem nhap captcha da dung chua
    $current_captcha = JBase::getSession()->get('captcha');
    
    if ($current_captcha != $captcha) {
      $ret = $this->message(1, 'forgot_password-message-captcha_is_not_matched', $this->app->lang('forgot_password-message-captcha_is_not_matched'));
      $this->renderJson($ret);
    }
    
    // kiem tra xem email co ton tai tren he thong khong?
    $result = $this->user_model->get(array ('email' => $email));
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'login-message-api_check_failed', $this->app->lang('login-message-api_check_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type != 0 ) {
      if (!isset($data->user) || empty($data->user->id)) {
        $ret = $this->message(1, 'forgot_password-message-email_does_not_exist', $this->app->lang('forgot_password-message-email_does_not_exist'));
        $this->renderJson($ret);
        
      } else {
        $ret = $this->message(1, 'login-message-' . $data->code, $this->app->lang('login-message-' . $data->code));
        $this->renderJson($ret);
      }
    }
    
    // build noi dung email gui cho khach hang
    $language = $this->app->appConf->language;
    $template_file = 'email_templates/' . $language . '/forgot_password.html';
    
    $href = $this->get_url_to_send_email($email, '/get-password');
    
    $body = $this->app->get_content_template($template_file, array('href'=> $href));
    
    $email_sender = $this->app->get_email_sender();
    
    $data = array (
      'to'=> $email,
      'subject' => $this->app->lang('forgot_password-title-forgot_password'),
      'body' => $body,
      'fromName' => 'Support'
    );
    
    $email_sender->post('/email', $data);
    
    $ret = $this->message(0, 'forgot_password-message-sent_email_ok', $this->app->lang('forgot_password-message-sent_email_ok'));
    $this->renderJson($ret);
  }
  
  /***
   * cho phep user thay doi mat khau
   * 
   * */
  public function get_password () {
    $this->app->prevent_remote_access();
    
    $password_new = $this->getSafe('password_new');
    $password_renew = $this->getSafe('password_renew');
    $email = $this->getSafe('email');
    
    $captcha = $this->getSafe('captcha');
    
    if (empty($email)) {
      $ret = $this->message(1, 'common-message-required_input_email', $this->app->lang('common-message-required_input_email'));
      $this->renderJson($ret);
    }
    
    if (empty($password_new)) {
      $ret = $this->message(1, 'get_password-message-required_password_new', $this->app->lang('get_password-message-required_password_new'));
      $this->renderJson($ret);
    }
    
    if (empty($password_renew)) {
      $ret = $this->message(1, 'get_password-message-required_password_renew', $this->app->lang('get_password-message-required_password_renew'));
      $this->renderJson($ret);
    }
    
    if ($password_new != $password_renew) {
      $ret = $this->message(1, 'get_password-message-password_new_and_password_renew_is_not_matched', $this->app->lang('get_password-message-password_new_and_password_renew_is_not_matched'));
      $this->renderJson($ret);
    }
    
    if (empty($captcha)) {
      $ret = $this->message(1, 'common-message-required_input_captcha', $this->app->lang('common-message-required_input_captcha'));
      $this->renderJson($ret);
    }
    
    // kiem tra xem nhap captcha da dung chua
    $current_captcha = JBase::getSession()->get('captcha');
    
    if ($current_captcha != $captcha) {
      $ret = $this->message(1, 'common-message-captcha_is_not_matched', $this->app->lang('common-message-captcha_is_not_matched'));
      $this->renderJson($ret);
    }
    
    // select lai user xem co ton tai khong?
    $result = $this->user_model->get(array ('email' => $email));
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'login-message-api_check_failed', $this->app->lang('login-message-api_check_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type != 0 ) {
      if (!isset($data->user) || empty($data->user->id)) {
        $ret = $this->message(1, 'get_password-message-email_does_not_exist', $this->app->lang('get_password-message-email_does_not_exist'));
        $this->renderJson($ret);
        
      } else {
        $ret = $this->message(1, 'login-message-' . $data->code, $this->app->lang('login-message-' . $data->code));
        $this->renderJson($ret);
      }
    }
   
    $user_id = $data->user->id;
    
    // update lai mat khau
    $data = array (
      'email' => $email,
      'password'=>$password_new,
      'updated_at'=>date('Y-m-d h:i:s'),
      'updated_by'=>$user_id 
    );
    
    $result = $this->user_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, 'get_password-message-' . $data->code, $this->app->lang('get_password-message-' . $data->code));
    
    $this->renderJson($ret);
  }
  
  /***
   * Tao url gui qua mail de user lay lai mat khau
   * 
   * */
  private function get_url_to_send_email ($email, $path) {
    $data_keys = array ();
    
    $base_url = $this->app->appConf->base_domain;
    $api_key = $this->app->appConf->app_api_key;
    $secret = $this->app->appConf->app_secret;
    $timeout = 3600; // 1 hour
    
    $data_keys['api_key'] = $api_key;
    $data_keys['expires'] = time() + $timeout;
    $data_keys['sign'] = generate_signal('GET', $secret, $path, $data_keys['expires'], array('email'=>$email));
    
    $data_keys_string = http_build_query($data_keys);
    return $base_url . $path . '?' . $data_keys_string . '&e=' . $email;
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
    $group_id      = $this->getSafe('group_id');
    $password   = $this->getSafe('password');
    $repassword = $this->getSafe('repassword');
    $sponsor_owner = $this->getSafe('sponsor_owner');
    $block = $this->getSafe('block');
    
    $required_fields = array(
      'user_name', 'display_name', 'email', 'mobile', 'password', 'repassword', 'group_id'
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
    
    // chua ton tai thi tao user
    $user = array (
      'display_name'=> $display_name,
      "user_name" => $user_name,
      "email" => $email,
      'password'=> $password,
      'group_id' => $group_id, 
      'mobile'=> $mobile, 
      'sponsor_owner'=> $sponsor_owner,
      'block'=>$block,
      'system_code'=> $system_code,
      'email_confirmed' => 1,
      'created_at'=>date('Y-m-d h:i:s'),
      'created_by'=> $this->app->user->data()->id
    );
    
    $result = $this->user_model->post($user);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type == 0) {
      $ret = $this->message(0, 'user-message-register_success', $this->app->lang('user-message-register_success'));
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
    
    $display_name  = $this->getSafe('display_name');
    $email      = $this->getSafe('email');
    $mobile     = $this->getSafe('mobile');
    $group_id      = $this->getSafe('group_id');
    $password   = $this->getSafe('password');
    $repassword = $this->getSafe('repassword');
    $sponsor_owner = $this->getSafe('sponsor_owner');
    
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
    
    if (empty($group_id)) {
      $ret = $this->message(1, 'user-message-required_group_id', $this->app->lang('user-message-required_input_group_id'));
      $this->renderJson($ret);
    }
    
    $system_code = $this->app->user->data()->system_code;
    
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
  
  public function get_list() {
    $this->app->prevent_remote_access();
    
    $system_code = $this->system_code();
    
    $db = $this->app->getDbo();
    
    $where = 'system_code=' . $db->quote($system_code);
    
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
  
  public function view() {
    $id = $this->getSafe('id');
    
    if (empty($id)) {
      $ret = $this->message(1, 'common-message-permission_denied_edit', $this->app->lang('common-message-permission_denied_edit'));
      $this->renderJson($ret);
    }
    
    $data = array(
      'id' => $id,
      'system_code' => $this->system_code()
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
   * Kich hoat tai khoan
   * 
   * */
  public function active_user () {
    $this->app->prevent_remote_access();
    
    $email = $this->getSafe('email');
    
    if (empty($email)) {
      $ret = $this->message(1, 'common-message-required_input_email', $this->app->lang('common-message-required_input_email'));
      $this->renderJson($ret);
    }
    
    // select lai user xem co ton tai khong?
    $result = $this->user_model->get(array ('email' => $email));
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'login-message-api_check_failed', $this->app->lang('login-message-api_check_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if ($data->type != 0 ) {
      if (!isset($data->user) || empty($data->user->id)) {
        $ret = $this->message(1, 'useractive-message-email_does_not_exist', $this->app->lang('useractive-message-email_does_not_exist'));
        $this->renderJson($ret);
        
      } else {
        $ret = $this->message(1, 'login-message-' . $data->code, $this->app->lang('login-message-' . $data->code));
        $this->renderJson($ret);
      }
    }
   
    $user_id = $data->user->id;
    
    // update lai mat khau
    $data = array (
      'email' => $email,
      'active'=> '2',
      'email_confirmed'=> '2',
      'updated_at'=>date('Y-m-d h:i:s'),
      'updated_by'=>$user_id 
    );
    
    $result = $this->user_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    $ret = $this->message($data->type, 'useractive-message-' . $data->code, $this->app->lang('useractive-message-' . $data->code));
    
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
}
?>