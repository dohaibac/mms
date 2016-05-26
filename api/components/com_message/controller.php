<?php
defined('BASEPATH') or die;

class MessageController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/message.php';
    
    $this->message_model =  new MessageModel($this->app);
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
   * view candidate
   * */
  public function view() {
    try {
      $id = $this->getSafe('id', 0);
      $system_code = $this->getSafe('system_code', '');
      
      if (empty($id)) {
        $ret = $this->message(1, 'message_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->message_model->get_by_id($id, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'message_view_not_found', 'Candidate not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('message_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'message_view_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser candidate
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
       if (empty($body)) {
         $ret = $this->message(1, 'message_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'title', 'message', 'gcm_regid', 'system_code', 'user_id', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'message_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $system_code = $body['system_code'];
       
       $inserted_id = $this->message_model->insert($body);
       
       $ret = $this->message(0, 'message_insert_success', 'Insert message has been successfully.');
       
       $ret['data'] = array('message_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('message_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'message_insert_exception', $ex->getMessage());
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
         $ret = $this->message(1, 'message_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $message = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) {
        $message = $this->message_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'message_update_missing_message_id', 'Missing user message id.');
        $this->renderJson($ret);
      }
  
      if (isset($message) && !empty($message->id)) {
       # list required fields:
         $required_fields = array (
           'title', 'message', 'registatoin_ids', 'user_id', 'system_code', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'message_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'message_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'message_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        $this->message_model->update_by_id($body);
        
        $ret = $this->message(0, 'message_update_success', 'Update candidate has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'message_update_does_not_exist', 'Message not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('message_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'message_update_exception', $ex->getMessage());
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
      
      $message = new stdClass;
      
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $message = $this->message_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'message_delete_missing_message_id', 'Missing candidate id.');
        $this->renderJson($ret);
      }
      
      if (isset($message) && !empty($message->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->message_model->delete_by_id($body);
          $ret = $this->message(0, 'message_delete_success', 'Delete candidate has been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'message_delete_message_not_found', 'Candidate not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('message_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'message_delete_exception', $ex->getMessage());
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
      
      $message_list = $this->message_model->get_list($data);
      
      $total_message_list = $this->message_model->get_list_total($where);
      
      $ret = array (
        'messages' => $message_list,
        'total' => $total_message_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('message_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'message_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>