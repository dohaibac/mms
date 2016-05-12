<?php
defined('BASEPATH') or die;

class GroupController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/group.php';
    
    $this->group_model =  new GroupModel($this->app);
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
      $id = $this->getSafe('id', 0);
      $system_code = $this->getSafe('system_code', '');
      
      if (empty($id)) {
        $ret = $this->message(1, 'group_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->group_model->get_by_id($id, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'group_view_not_found', 'User group does not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('group_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'group_view_exception', EXCEPTION_ERROR_MESSAGE);
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
       * system_code
       * created_at
       * created_by
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'group_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'name', 'ord', 'system_code', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'group_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $system_code = $body['system_code'];
       
       // kiem tra xem user group da ton tai hay chua?
       $usergroup = $this->group_model->get_group_by_name($body['name'], $system_code);
       
       if (isset($usergroup) && isset($usergroup->id)) {
         $ret = $this->message(1, 'group_insert_exist', 'User group already existed.');
       
         $this->renderJson($ret);
       }
       
       $inserted_id = $this->group_model->insert($body);
       
       $ret = $this->message(0, 'group_insert_success', 'Insert user group successfully.');
       
       $ret['data'] = array('group_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('group_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'group_insert_exception', EXCEPTION_ERROR_MESSAGE);
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
         $ret = $this->message(1, 'group_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $usergroup = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $usergroup = $this->group_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'group_update_missing_group_id', 'Missing user group id.');
        $this->renderJson($ret);
      }
  
      if (isset($usergroup) && !empty($usergroup->id)) {
        // update usergroup
        // validate data
        
        # list required fields:
         $required_fields = array (
           'name', 'ord', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'group_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'group_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'group_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        // valid unique key
        if (isset($body['name'])) {
          $check_exist_name = $this->group_model->get_group_by_name_and_dif_id($body['name'], $usergroup->id);
          
          if (isset($check_exist_name) && !empty ($check_exist_name->id)) {
            $ret = $this->message(1, 'group_update_name_exist', 'This name already exist.');
            $this->renderJson($ret);
          }
        }
        
        $this->group_model->update_by_id($body);
        
        $ret = $this->message(0, 'group_update_success', 'Update group has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'group_update_does_not_exist', 'Group does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('group_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'group_update_exception', EXCEPTION_ERROR_MESSAGE);
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
      
      $usergroup = new stdClass;
      
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $usergroup = $this->group_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'group_delete_missing_group_id', 'Missing group id.');
        $this->renderJson($ret);
      }
      
      if (isset($usergroup) && !empty($usergroup->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->group_model->delete_by_id($body);
          $ret = $this->message(0, 'group_delete_success', 'Delete group have been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'group_delete_user_not_found', 'Group not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('group_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'group_delete_exception', EXCEPTION_ERROR_MESSAGE);
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
      
      $group_list = $this->group_model->get_list($data);
      
      $total_user_group_list = $this->group_model->get_list_total($where);
      
      $ret = array (
        'groups' => $group_list,
        'total' => $total_user_group_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('group_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'group_get_list_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
}
?>