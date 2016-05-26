<?php
defined('BASEPATH') or die;

class GcmController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/gcm.php';
    
    $this->gcm_model =  new GcmModel($this->app);
    
    require_once PATH_COMPONENT . '/com_user/models/user.php';
    
    $this->user_model =  new UserModel($this->app);
  }

  public function register() {
    try {
      $data = file_get_contents('php://input');
      
      $data = json_decode($data, true);
      
      $email = isset($data['email']) ? $data['email'] : '';
      $password = isset($data['password']) ? $data['password'] : '';
      $gcm_regid = isset($data['gcm_regid']) ? $data['gcm_regid'] : '';
      $hardware_id = isset($data['hardware_id']) ? $data['hardware_id'] : '';
      $hardware_info = isset($data['hardware_info']) ? $data['hardware_info'] : '';
      $system_code = isset($data['system_code']) ? $data['system_code'] : '';
      
      if (empty($system_code)) {
        $system_code = $this->app->appConf->default_system_code;
      }
      
      if (empty($email)) {
        $ret = $this->message_response(0, 'register', 'Bạn chưa nhập tên đăng nhập!');
        $this->renderJson($ret);
      }
      
      if (empty($password)) {
        $ret = $this->message_response(0, 'register', 'Bạn chưa nhập mật khẩu!');
        $this->renderJson($ret);
      }
      if (empty($gcm_regid)) {
        $ret = $this->message_response(0, 'register', 'gcm_regid is required field.');
        $this->renderJson($ret);
      }
      if (empty($hardware_id)) {
        $ret = $this->message_response(0, 'register', 'hardware_id is required field.');
        $this->renderJson($ret);
      }
      if (empty($hardware_info)) {
        $ret = $this->message_response(0, 'register', 'hardware_info is required field.');
        $this->renderJson($ret);
      }
      // kiem tra xem user co ton tai khong
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
        // verify ok, register
        $result = $this->gcm_model->post(array(
          'gcm_regid' => $gcm_regid,
          'email' => $email,
          'user_id' => $user->id,
          'system_code' => $system_code,
          'hardware_id' => $hardware_id,
          'hardware_info' => $hardware_info
        ));
        
        if (!isset($result) || empty($result->body)) {
          $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
          $this->renderJson($ret);
        }
        
        $data = $result->body;
        
        if ($data->type == 0) {
          $ret = $this->message_response(1, 'register', 'Đăng ký thành công!');
          $this->renderJson($ret);
        }
        
        $ret = $this->message_response(0, 'register', $data->message);
    
        $this->renderJson($ret);
        
      } else {
        $ret = $this->message_response(0, 'register', 'Sai email hoặc mật khẩu!');
        $this->renderJson($ret);
      }
      
     }
     else {
       if ($data->code == 'user_view_not_found') {
         $ret = $this->message_response(0, 'register', 'Sai email hoặc mật khẩu!');
         $this->renderJson($ret);
       }
       else {
         $ret = $this->message_response(0, 'register', $data->message);
         $this->renderJson($ret);
       }
     } 
    } catch (Exception $ex) {
       $ret = $this->message(1, 'gcm_register_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  public function logout() {
    try {
      
      $data = file_get_contents('php://input');
      
      $data = json_decode($data, true);
      
      $hardware_id = isset($data['hardware_id']) ? $data['hardware_id'] : '';
      
      if (empty($hardware_id)) {
        $ret = $this->message_response(0, 'logout', 'hardware_id is required field.');
        $this->renderJson($ret);
      }
      
      $result = $this->gcm_model->delete(array(
        'hardware_id' => $hardware_id
      ));
      
      $data = $result->body;
      
      if ($data->type == 0) {
        $ret = $this->message_response(1, 'logout', 'Đăng xuất thành công!');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message_response(0, 'logout', $data->message);
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $ret = $this->message(1, 'gcm_logout_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  public function update() {
    try {
        
      $data = file_get_contents('php://input');
      
      $data = json_decode($data, true);
      
      $ids = isset($data['ids']) ? $data['ids'] : '';
      $status = isset($data['status']) ? $data['status'] : '';
      
      if (empty($ids)) {
        $ret = $this->message_response(0, 'update', 'ids is required field.');
        $this->renderJson($ret);
      }
      if (empty($status)) {
        $ret = $this->message_response(0, 'update', 'status is required field.');
        $this->renderJson($ret);
      }
      
      $ret = $this->message_response(0, 'update', 'Update message has been successfully.');
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $ret = $this->message(1, 'gcm_logout_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  public function get_list() {
    $system_code = '06';
    
    $db = $this->app->getDbo();
    
    $where = 'system_code=' . $db->quote($system_code);
    
    $current_page = empty($this->data['page']) ? 1 : $this->data['page'];
    $order_by ='id DESC';
    
    $data = array (
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page
    );
     
    $result = $this->gcm_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    return $data;
  }
  
  public function send_notification() {
    //$this->app->prevent_remote_access();
     
    $registatoin_ids = $this->getSafe('registatoin_ids');
    
    $title = $this->getSafe('title');
    $message = $this->getSafe('message');
    $message_id = time();
    
    if (empty($registatoin_ids)) {
      $ret = $this->message(1, 'gcm_send_notification_required_registatoin_ids', 'registatoin_ids is required field.');
      $this->renderJson($ret);
    }
    if (empty($title)) {
      $ret = $this->message(1, 'gcm_send_notification_required_title', 'title is required field.');
      $this->renderJson($ret);
    }
    if (empty($message)) {
      $ret = $this->message(1, 'gcm_send_notification_required_message', 'message is required field.');
      $this->renderJson($ret);
    }
    
    $data = array(
      'registatoin_ids' => array($registatoin_ids),
      'message' => array(
        'message_id' => $message_id,
        'title' => $title, 
        'content' => $message, 
        'timeStamp' => date('Y-m-d h:i:s'),
        /*'time_to_live' => '10',*/
        'sound'=>'notification'
      )
    );
    
    $result = $this->gcm_model->send_notification($data);
    
    $ret = $result->body;
    
    $this->renderJson($ret);
  }

  public function get_list_mobile() {
    $user_id = $this->getSafe('user_id');
    $system_code = $this->getSafe('system_code');
    
    $db = $this->app->getDbo();
     
    $where = 'user_id=' . $db->quote($user_id) . ' AND system_code=' . $db->quote($system_code);
    
    $result = $this->gcm_model->get_list(array('where'=>$where));
    
    $ret = $result->body;
    
    $this->renderJson($ret);
  }
}
?>