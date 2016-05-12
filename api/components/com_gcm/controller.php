<?php
defined('BASEPATH') or die;

class GcmController extends JControllerGcm
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/gcm.php';
    
    $this->gcm_model =  new GcmModel($this->app);
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
   * Inser user group
   * */
  public function view() {
    try {
      // check get user group theo id
      $email = $this->getSafe('email', 0);
      $system_code = $this->getSafe('system_code', 0);
      
      if (empty($email)) {
        $ret = $this->message(1, 'gcm_view_missing_email', 'Missing or Empty email.');
        $this->renderJson($ret);
      }
      
      if (empty($system_code)) {
        $ret = $this->message(1, 'gcm_view_missing_system_code', 'Missing or Empty system_code.');
        $this->renderJson($ret);
      }
      
      $ret = $this->gcm_model->get_user_by_email($email, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'gcm_view_not_found', 'User not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('gcm_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gcm_view_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser user group
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
       * name
       * ord 
       * created_at
       * created_by
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'gcm_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       if (!isset($body['created_at'])) {
         $body['created_at'] = date('Y-m-d h:i:s');
       }
       
       if (!isset($body['created_by'])) {
         $body['created_by'] = 1;
       }
       
       $required_fields = array (
         'gcm_regid', 'email', 'system_code', 'hardware_id', 'hardware_info', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'gcm_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $hardware_id = $body['hardware_id'];
       
       // kiem tra xem hardware_id da ton tai chua?
       $gcm = $this->gcm_model->get_by_hardware_id($hardware_id);
       
       if (isset($gcm) && !empty($gcm->id)) {
         // update theo hardware_id
         $data = array(
          'gcm_regid' => $body['gcm_regid'],
          'email' => $body['email'],
          'system_code' => $body['system_code'],
          'hardware_id' => $body['hardware_id'],
          'hardware_info' => $body['hardware_info'],
          'updated_at' => date('Y-m-d h:i:s'),
          'updated_by' => 1,
         );
         
         $this->gcm_model->update_by_hardware_id($data);
         $ret = $this->message(0, 'gcm_insert_success', 'Update gcm successfully.');
         $this->renderJson($ret);
       }
       else {
         $inserted_id = $this->gcm_model->insert($body);
       }
       
       $ret = $this->message(0, 'gcm_insert_success', 'Insert gcm successfully.');
       
       $ret['data'] = array('gcm_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('gcm_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'gcm_insert_exception', EXCEPTION_ERROR_MESSAGE);
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
         $ret = $this->message(1, 'gcm_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $menu = new stdClass;
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $menu = $this->gcm_model->get_by_id($body['id']);
      }
      else {
        $ret = $this->message(1, 'gcm_update_missing_gcm_id', 'Missing menu id.');
        $this->renderJson($ret);
      }
  
      if (isset($menu) && !empty($menu->id)) {
        // update usergroup
        // validate data
        
        # list required fields:
         $required_fields = array (
           'name', 'ord', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'gcm_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'gcm_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'gcm_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        $this->gcm_model->update_by_id($body);
        
        $ret = $this->message(0, 'gcm_update_success', 'Update menu has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'gcm_update_does_not_exist', 'Menu is not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('gcm_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gcm_update_exception', EXCEPTION_ERROR_MESSAGE);
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
      
      $gcm = new stdClass;
      
      if (isset($body['hardware_id']) && !empty($body['hardware_id'])) {
        $gcm = $this->gcm_model->get_by_hardware_id($body['hardware_id']);
      }
      else {
        $ret = $this->message(1, 'gcm_delete_missing_hardware_id', 'Missing hardware_id.');
        $this->renderJson($ret);
      }
      
      if (isset($gcm) && !empty($gcm->id)) {
        $this->gcm_model->delete_by_hardware_id($body['hardware_id']);
        $ret = $this->message(0, 'gcm_delete_success', 'Delete gcm successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'gcm_delete_gcm_not_found', 'GCM  not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('gcm_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gcm_delete_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
  
  /***
   * Lay danh sach menu theo paging
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
        // search theo name
        $search .= $db->quoteName('name') . ' LIKE ' . $keywords;
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
      
      $gcm_list = $this->gcm_model->get_list($data);
      
      $total_gcm_list = $this->gcm_model->get_list_total($where);
      
      $ret = array (
        'gcms' => $gcm_list,
        'total' => $total_gcm_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('gcm_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gcm_get_list_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }

  public function send_notification() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
       if (empty($body)) {
         $ret = $this->message(1, 'gcm_send_notification_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $registatoin_ids = $body['registatoin_ids'];
       $message = $body['message'];
       
        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';
 
        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $message,
        );
 
        $headers = array(
          'Authorization: key=' . $this->app->appConf->google_api_key,
          'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
 
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
 
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
 
        // Close connection
        curl_close($ch);
        
        $ret = $this->message(0, 'send_notification_ok', $result);
       
        $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('gcm_send_notification_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'gcm_send_notification_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
}
?>