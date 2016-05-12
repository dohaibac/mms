<?php
defined('BASEPATH') or die;

class UserController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/user.php';
    
    $this->user_model =  new UserModel($this->app);
  }
   
  /***
   * Common function
   * 
   * detect insert, update, delete
   * 
   * */
  public function index () {
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    
    switch ($method) {
      case 'GET':
        $this->view();
        break;
      case 'POST':
        $this->insert();
        break;
      case 'PUT':
        $this->update();
        break;
      case 'DELETE':
        $this->delete();
        break;
      default:
        break;
    }
  }
  
  /***
   * Inser user
   * */
  public function view() {
    try {
      // check get user theo id hay email
      $data = $this->data;
      
      $ret = array ();
      
      if (empty($data)) {
        $ret = $this->message(1, 'user_view_invalid_input', 'Invalid input value.');
        $this->renderJson($ret);
      }
      
      if (!isset($data['system_code']) || empty($data['system_code'])) {
        $ret = $this->message(1, 'user_view_system_code_required', 'Required system_code.');
        $this->renderJson($ret);
      }
      
      $sytem_code = $data['system_code'];
      
      if (isset($data['id'])) {
        $user = $this->user_model->get_by_id($data['id'], $sytem_code);
      } 
      else {
        $user = $this->user_model->get_user_by_email_system_code($data['email'], $data['system_code']);
      }
       
      if (empty($user)) {
        $ret = $this->message(1, 'user_view_not_found', 'User does not exist.');
        $this->renderJson($ret);
      }
      
      if (!isset($data['include_password']) || empty($data['include_password'])) {
        unset($user->password);
      }
      $ret = $this->message(0, 'user_view_found', 'Found user.');
      $ret['user'] = $user;
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('user_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'user_view_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  
   /***
   * Get theo username
   * */
  public function get_by_username() {
    try {
      $data = $this->data;
      
      $ret = array ();
      
      if (empty($data)) {
        $ret = $this->message(1, 'user_get_by_username_invalid_input', 'Invalid input value.');
        $this->renderJson($ret);
      }
      
      if (!isset($data['system_code']) || empty($data['system_code'])) {
        $ret = $this->message(1, 'user_get_by_username_system_code_required', 'Required system_code.');
        $this->renderJson($ret);
      }
      
      $sytem_code = $data['system_code'];
      
      $user = $this->user_model->get_by_user_name($data['user_name'], $data['system_code']);
       
      if (empty($user)) {
        $ret = $this->message(1, 'user_get_by_username_not_found', 'User does not exist.');
        $this->renderJson($ret);
      }
      
      $ret = $this->message(0, 'user_view_found', 'Found user.');
      
      $ret['user'] = $user;
      
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('user_get_by_username_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'user_get_by_username_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * Get theo username
   * */
  public function get_by_email() {
    try {
      $data = $this->data;
      
      $ret = array ();
      
      if (empty($data)) {
        $ret = $this->message(1, 'user_get_by_email_invalid_input', 'Invalid input value.');
        $this->renderJson($ret);
      }
      
      if (!isset($data['system_code']) || empty($data['system_code'])) {
        $ret = $this->message(1, 'user_get_by_email_required', 'Required system_code.');
        $this->renderJson($ret);
      }
      
      $sytem_code = $data['system_code'];
      
      $user = $this->user_model->get_by_email($data['email'], $data['system_code']);
       
      if (empty($user)) {
        $ret = $this->message(1, 'user_get_by_email_not_found', 'User does not exist.');
        $this->renderJson($ret);
      }
      
      $ret = $this->message(0, 'user_get_by_email_found', 'Found user.');
      
      $ret['user'] = $user;
      
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('user_get_by_email_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'user_get_by_email_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  
  /***
   * Get theo username
   * */
  public function get_by_group_id() {
    try {
      $data = $this->data;
      
      $ret = array ();
      
      if (empty($data)) {
        $ret = $this->message(1, 'user_get_by_group_id_invalid_input', 'Invalid input value.');
        $this->renderJson($ret);
      }
      
      if (!isset($data['group_id']) || empty($data['group_id'])) {
        $ret = $this->message(1, 'user_get_by_group_id_required_group_id', 'Required system_code.');
        $this->renderJson($ret);
      }
      
      if (!isset($data['system_code']) || empty($data['system_code'])) {
        $ret = $this->message(1, 'user_get_by_group_id_required_system_code', 'Required system_code.');
        $this->renderJson($ret);
      }
      
      $sytem_code = $data['system_code'];
      
      $users = $this->user_model->get_by_group_id($data['group_id'], $data['system_code']);
       
      if (empty($users)) {
        $ret = $this->message(1, 'user_get_by_group_id_not_found', 'User does not exist.');
         $ret['users'] = array();
        $this->renderJson($ret);
      }
      
      $ret = $this->message(0, 'user_get_by_group_id_found', 'Found user.');
      
      $ret['users'] = $users;
      
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('user_get_by_group_id_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'user_get_by_group_id_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser user
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      /***
       * validate required fields
       * 
       * List required fields:
       * 
       * user_name
       * email
       * password
       * group_id
       * created_at
       * created_by
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'user_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'user_name', 'email', 'password', 'group_id', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'user_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       if (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
         $ret = $this->message(1, 'user_insert_email_invalid', 'Email invalid.');
         $this->renderJson($ret);
       }
      
       // kiem tra xem user da ton tai hay chua?
       $user = $this->user_model->get_user_by_email($body['email']);
       
       if (isset($user) && isset($user->id)) {
         $ret = $this->message(1, 'user_insert_exist', 'User already existed.');
       
         $this->renderJson($ret);
       }
       
       // set default value
       /***
        * List default fiedls
        * block
        * send_mail
        * active
        * user_type
        * email_confirmed
        * 
        * */
       
       $body['block']     = isset($body['block'])     ? $body['block'] : 0;
       $body['send_mail'] = isset($body['send_mail']) ? $body['send_mail'] : 0;
       $body['active']    = isset($body['active'])    ? $body['active'] : 1;
       $body['user_type'] = isset($body['user_type'])  ? $body['user_type'] : 1;
       $body['email_confirmed'] = isset($body['email_confirmed'])  ? $body['email_confirmed'] : 1;
       
       $body['display_name'] = isset($body['display_name'])  ? $body['display_name'] : '';
       $body['mobile']       = isset($body['mobile'])        ? $body['mobile'] : '';
       $body['avatar']       = isset($body['avatar'])        ? $body['avatar'] : '';
       $body['addr']         = isset($body['addr'])          ? $body['addr'] : '';
       
       require_once PATH_PLUGINS . '/hash/crypt.php';
       $hash = new HashPassword();
      
       $body['password'] = $hash->generateHash($body['password']);
       
       $inserted_id = $this->user_model->insert($body);
       
       $ret = $this->message(0, 'user_insert_success', 'Insert user successfully.');
       $ret['data'] = array('user_id' => $inserted_id);
       $this->renderJson($ret);
     } catch (Exception $ex) {
       $this->app->write_log('user_insert_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'user_insert_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * update user
   * */
  public function update() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      if (empty($body)) {
         $ret = $this->message(1, 'user_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $user = new stdClass;
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $user = $this->user_model->get_by_id($body['id']);
      }
      else if (isset($body['email']) && !empty($body['email'])) {
        if (!filter_var($body['email'], FILTER_VALIDATE_EMAIL)) {
         $ret = $this->message(1, 'user_update_email_invalid', 'Email invalid.');
         $this->renderJson($ret);
        }
        // check xem co ton tai hay khong?
        $user = $this->user_model->get_user_by_email($body['email']);
      } 
      else {
        $ret = $this->message(1, 'user_update_missing_user_id_or_email', 'Missing user id or email.');
        $this->renderJson($ret);
      }
  
      if (isset($user) && !empty($user->id)) {
        // update user
        // validate data
        
        # list required fields:
         $required_fields = array (
           'user_name', 'email', 'password', 'send_mail', 'created_at', 'created_by', 
           'active', 'group_id', 'user_type', 'email_confirmed'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'user_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'user_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'user_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        // if update password
        if (isset($body['password'])) {
          require_once PATH_PLUGINS . '/hash/crypt.php';
          $hash = new HashPassword();
          
          $body['password'] = $hash->generateHash($body['password']);
        }
        
        if (isset($body['id'])) {
          // valid unique key
          if (isset($body['email'])) {
            $check_exist_email = $this->user_model->get_user_by_email_and_dif_id($body['email'], $user->id);
            
            if (isset($check_exist_email) && !empty ($check_exist_email->id)) {
              $ret = $this->message(1, 'user_update_email_exist', 'This email already exist.');
              $this->renderJson($ret);
            }
          }
          $this->user_model->update_by_id($body);
        } else {
          $this->user_model->update_by_email($body);
        }
        
        $ret = $this->message(0, 'user_update_success', 'Update user has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'user_update_does_not_exist', 'User does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('user_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'user_update_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
/***
   * delete user
   * */
  public function delete() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      $user = new stdClass;
      
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $user = $this->user_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'delete_delete_missing_group_id', 'Missing group id.');
        $this->renderJson($ret);
      }
      
      if (isset($user) && !empty($user->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->user_model->delete_by_id($body);
          $ret = $this->message(0, 'delete_delete_success', 'Delete user group have been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'delete_delete_user_not_found', 'User not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('delete_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'delete_delete_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }

  /***
   * Lay danh sach user theo paging
   * 
   * */
  public function get_list() {
    try {
      $limit = $this->getSafe('limit', $this->app->appConf->page_size);
      $page_number = $this->getSafe('page_number', 1);
      $where = $this->getSafe('where', '');
      $order_by = $this->getSafe('order_by', '');
      $keywords = $this->getSafe('keywords', '');
      
      $page_number = empty($page_number) ? 1 : $page_number;
      
      $start_index = ($page_number -1) * $limit;
      
      $db = $this->app->getDbo();
      
      $search = '';
      
      if (!empty($keywords)) {
        $keywords = $db->quote('%' . $keywords . '%');
        // search theo email
        $search .= $db->quoteName('email') . ' LIKE ' . $keywords;
        // search theo mobile
        $search .= ' OR ' . $db->quoteName('mobile') . ' LIKE ' . $keywords;
        // search theo display_name
        $search .= ' OR ' . $db->quoteName('display_name') . ' COLLATE utf8_general_ci LIKE ' . $keywords;
      }
      
      if (!empty ($where)) {
        if (!empty ($search)) {
          $where = ' AND (' . $search . ')';
        }
      } else {
        $where = $search;
      }
      
      $data = array (
        'limit' => $limit,
        'start_index' => $start_index,
        'order_by' => $order_by,
        'where' => $where
      );
      
      $user_list = $this->user_model->get_list($data);
      
      $total_user_list = $this->user_model->get_list_total($where);
      
      $ret = array (
        'users' => $user_list,
        'total' => $total_user_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('user_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'user_get_list_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
}
?>