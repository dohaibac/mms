<?php
defined('BASEPATH') or die;

class ServiceController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/service.php';
    
    $this->service_model =  new ServiceModel($this->app);
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
   * Inser service
   * */
  public function view() {
    try {
      // check get user group theo id
      $id = $this->getSafe('id', 0);
      
      if (empty($id)) {
        $ret = $this->message(1, 'service_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->service_model->get_by_id($id);
      
      if (empty($ret)) {
        $ret = $this->message(1, 'service_view_not_found', 'Service does not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('service_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'service_view_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser service
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
       * code
       * block 
       * created_at
       * created_by
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'service_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'name', 'block', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'service_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       // kiem tra xem service da ton tai hay chua?
       $service = $this->service_model->get_by_name($body['name']);
       
       if (isset($service) && isset($service->id)) {
         $ret = $this->message(1, 'service_insert_exist', 'Service name already existed.');
       
         $this->renderJson($ret);
       }
       
       if (!isset($body['code'])) {
         $body['code'] = '';
       }
       
       $inserted_id = $this->service_model->insert($body);
       
       $ret = $this->message(0, 'service_insert_success', 'Insert service successfully.');
       
       $ret['data'] = array('service_id' => $inserted_id);
       
       if (empty($body['code'])) {
         // update code
         $data = array(
          'id' => $inserted_id, 
          'code' => $this->app->appConf['service_code_prefix'] . add_zero_in_single_number($inserted_id)
         );
         
         $this->service_model->update_by_id($data);
       }
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('service_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'service_insert_exception', EXCEPTION_ERROR_MESSAGE);
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
         $ret = $this->message(1, 'service_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $service = new stdClass;
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $service = $this->service_model->get_by_id($body['id']);
      }
      else {
        $ret = $this->message(1, 'service_update_missing_group_id', 'Missing service id.');
        $this->renderJson($ret);
      }
  
      if (isset($service) && !empty($service->id)) {
        // update service
        // validate data
        
        # list required fields:
         $required_fields = array (
           'name', 'code', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'service_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'service_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'service_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        // valid unique key
        if (isset($body['name'])) {
          $check_exist_name = $this->service_model->get_by_name_and_dif_id($body['name'], $service->id);
          
          if (isset($check_exist_name) && !empty ($check_exist_name->id)) {
            $ret = $this->message(1, 'service_update_name_exist', 'This service name already exist.');
            $this->renderJson($ret);
          }
        }
        
        $this->service_model->update_by_id($body);
        
        $ret = $this->message(0, 'service_update_success', 'Update service has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'service_update_does_not_exist', 'Service does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('service_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'service_update_exception', EXCEPTION_ERROR_MESSAGE);
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
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $usergroup = $this->service_model->get_by_id($body['id']);
      }
      else {
        $ret = $this->message(1, 'service_delete_missing_group_id', 'Missing group id.');
        $this->renderJson($ret);
      }
      
      if (isset($usergroup) && !empty($usergroup->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->service_model->delete_by_id($body);
          $ret = $this->message(0, 'service_delete_success', 'Delete service have been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'service_delete_not_found', 'Service not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('service_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'service_delete_exception', EXCEPTION_ERROR_MESSAGE);
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
      
      $service_list = $this->service_model->get_list($data);
      
      $total_service_list = $this->service_model->get_list_total($where);
      
      $ret = array (
        'services' => $service_list,
        'total' => $total_service_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('service_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'service_get_list_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
}
?>