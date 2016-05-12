<?php
defined('BASEPATH') or die;

class DevkeyController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/devkey.php';
    
    $this->devkey_model =  new DevkeyModel($this->app);
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
      // check get devkey theo id
      $id = $this->getSafe('id', 0);
      
      if (empty($id)) {
        $ret = $this->message(1, 'devkey_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->devkey_model->get_by_id($id);
      
      if (empty($ret)) {
        $ret = $this->message(1, 'usergroup_view_not_found', 'Devkey does not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('devkey_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'devkey_view_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser devkey
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
       * api_key
       * secret
       * app_name
       * block
       * api_code
       * allow_ips
       *  
       * created_at
       * created_by
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'devkey_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'api_key', 'secret', 'app_name', 'api_code', 'allow_ips', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'devkey_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       if (isset($body['api_key']) && strlen($body['api_key']) != 32) {
          $ret = $this->message(1, 'devkey_insert_api_key_length_invalid', 'Length of api_key should be equal 32 characters.');
          $this->renderJson($ret);
        }
       
       if (isset($body['secret']) && strlen($body['secret']) != 16) {
          $ret = $this->message(1, 'devkey_insert_secret_length_invalid', 'Length of secret should be equal 16 characters.');
          $this->renderJson($ret);
        }
       
       // kiem tra xem devkey da ton tai hay chua?
       $devkey = $this->devkey_model->get_by_api_key($body['api_key']);
       
       if (isset($devkey) && isset($devkey->id)) {
         $ret = $this->message(1, 'devkey_insert_exist', 'api_key already existed.');
       
         $this->renderJson($ret);
       }
       
       $inserted_id = $this->devkey_model->insert($body);
       
       $ret = $this->message(0, 'devkey_insert_success', 'Insert devkey successfully.');
       
       $ret['data'] = array('devkey_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('devkey_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'devkey_insert_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * update devkey
   * */
  public function update() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      if (empty($body)) {
         $ret = $this->message(1, 'devkey_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $devkey = new stdClass;
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $devkey = $this->devkey_model->get_by_id($body['id']);
      }
      else {
        $ret = $this->message(1, 'devkey_update_missing_devkey_id', 'Missing devkey id.');
        $this->renderJson($ret);
      }
  
      if (isset($devkey) && !empty($devkey->id)) {
        // validate data
        
        # list required fields:
         $required_fields = array (
           'api_key', 'secret', 'app_name', 'block', 'api_code', 'allow_ips', 
           'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'devkey_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'devkey_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'devkey_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        // valid length api_key, secret
        // valid unique key
        if (isset($body['api_key'])) {
          if (strlen($body['api_key']) != 32) {
            $ret = $this->message(1, 'devkey_update_api_key_length_invalid', 'Length of api_key should be equal 32 characters.');
            $this->renderJson($ret);
          } 
          $check_exist_key = $this->devkey_model->get_by_api_key_and_dif_id($body['api_key'], $devkey->id);
          
          if (isset($check_exist_key) && !empty ($check_exist_key->id)) {
            $ret = $this->message(1, 'devkey_update_api_key_exist', 'This api_key already exist.');
            $this->renderJson($ret);
          }
        }
        
        if (isset($body['secret']) && strlen($body['secret']) != 16) {
          $ret = $this->message(1, 'devkey_update_secret_length_invalid', 'Length of secret should be equal 16 characters.');
          $this->renderJson($ret);
        }
        
        $this->devkey_model->update_by_id($body);
        
        $ret = $this->message(0, 'devkey_update_success', 'Update devkey has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'devkey_update_does_not_exist', 'Devkey does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('devkey_update_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'devkey_update_exception', EXCEPTION_ERROR_MESSAGE);
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
      
      $devkey = new stdClass;
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $devkey = $this->devkey_model->get_by_id($body['id']);
      }
      else {
        $ret = $this->message(1, 'devkey_delete_missing_devkey_id', 'Missing devkey id.');
        $this->renderJson($ret);
      }
      
      if (isset($devkey) && !empty($devkey->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->devkey_model->delete_by_id($body);
          $ret = $this->message(0, 'devkey_delete_success', 'Delete devkey have been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'devkey_delete_devkey_not_found', 'Devkey not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('devkey_delete_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'devkey_delete_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * Lay danh sach user group theo paging
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
        $search .= $db->quoteName('api_key') . ' LIKE ' . $keywords;
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
      
      $devkey_list = $this->devkey_model->get_list($data);
      
      $total_devkey_list = $this->devkey_model->get_list_total($where);
      
      $ret = array (
        'devkeys' => $devkey_list,
        'total' => $total_devkey_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('devkey_get_list_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'devkey_get_list_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }

  /***
   * Lay theo api_key
   * 
   * 
   * */
  public function get_by_api_key() {
    try {
      $api_key = $this->getSafe('key', '');
      
      if (empty($api_key)) {
        $ret = $this->message(1, 'devkey_get_by_api_key_required_api_key', 'Required api_key.');
        $this->renderJson($ret);
      }
      
      $devkey = $this->devkey_model->get_by_api_key($api_key);
      
      $ret = $this->message(0, 'devkey_get_by_api_key_found', 'Found devkey.'); 
      $ret['devkey'] = $devkey;
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('devkey_get_by_api_key_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'devkey_get_by_api_key_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
}
?>