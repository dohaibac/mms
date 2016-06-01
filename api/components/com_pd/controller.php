<?php
defined('BASEPATH') or die;

class PdController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/pd.php';
    $this->pd_model =  new PdModel($this->app);
    
    require_once (__DIR__ . '/../com_sponsor/models/sponsor.php');
    $this->sponsor_model =  new SponsorModel($this->app);
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
        $ret = $this->message(1, 'pd_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->pd_model->get_by_id($id, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'pd_view_not_found', 'PD does not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('pd_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pd_view_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser pd
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
       if (empty($body)) {
         $ret = $this->message(1, 'pd_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'code', 'sponsor', 'amount', 'issued_at', 'system_code', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'pd_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $system_code = $body['system_code'];
       
       // kiem tra xem pd da ton tai chua
       $exist = $this->pd_model->get_by_code($body['code'], $system_code);
       
       if (isset($exist) && isset($exist->id)) {
         $ret = $this->message(1, 'pd_insert_exist', 'Pd already existed.');
       
         $this->renderJson($ret);
       }
       
       $inserted_id = $this->pd_model->insert($body);
       
       $ret = $this->message(0, 'pd_insert_success', 'Insert pd successfully.');
       
       $ret['data'] = array('pd_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('pd_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'pd_insert_exception', $ex->getMessage());
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
         $ret = $this->message(1, 'pd_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $exist = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $exist = $this->pd_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'pd_update_missing_pd_id', 'Missing user bank id.');
        $this->renderJson($ret);
      }
  
      if (isset($exist) && !empty($exist->id)) {
        // validate data
        
        # list required fields:
        $required_fields = array (
         'sponsor', 'system_code', 'created_at', 'created_by'
        );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'pd_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'pd_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'pd_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        // valid unique key
        if (isset($body['code'])) {
          $check_exist_name = $this->pd_model->get_pd_by_code_and_dif_id($body['code'], $exist->id);
          
          if (isset($check_exist_name) && !empty ($check_exist_name->id)) {
            $ret = $this->message(1, 'pd_update_exist', 'Pd already exist.');
            $this->renderJson($ret);
          }
        }
        
        $this->pd_model->update_by_id($body);
        
        $ret = $this->message(0, 'pd_update_success', 'Update Pd has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'pd_update_does_not_exist', 'Pd does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('pd_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pd_update_exception', $ex->getMessage());
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
        $usergroup = $this->pd_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'pd_delete_missing_pd_id', 'Missing pd id.');
        $this->renderJson($ret);
      }
      
      if (isset($usergroup) && !empty($usergroup->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->pd_model->delete_by_id($body);
          $ret = $this->message(0, 'pd_delete_success', 'Delete Pd has been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'pd_delete_pd_not_found', 'Pd not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('pd_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pd_delete_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
  
  /***
   * Lay danh sach user group theo paging
   * 
   * */
  public function get_list() {
    try {
      $sponsor_owner = $this->getSafe('sponsor_owner', '');
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
      
      $sponsor_username = $this->sponsor_model->get_list_username_by_path($sponsor_owner);
      if($sponsor_username != ""){
         $where .= ' AND sponsor in ('. $sponsor_username .')';
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
      
      $pd_list = $this->pd_model->get_list($data);
      
      $total_user_pd_list = $this->pd_model->get_list_total($where);
      
      $ret = array (
        'pds' => $pd_list,
        'total' => $total_user_pd_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('pd_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pd_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
  
  /***
   * get total in each status of PD 
   * 
   * */
  public function get_status() {
    try {

      $db = $this->app->getDbo();

      $pd_status = $this->pd_model->get_status();

      $ret = array (
        'pds' => $pd_status,
      );

      $this->renderJson($ret);

     } catch (Exception $ex) {
       $this->app->write_log('pd_get_status_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pd_get_status_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
  
   /***
   * get total in each status of PD 
   * 
   * */
  public function get_all() {
    try {

      $db = $this->app->getDbo();

      $pds = $this->pd_model->get_all($this->data);

      $ret = array (
        'pds' => $pds,
      );

      $this->renderJson($ret);

     } catch (Exception $ex) {
       $this->app->write_log('pd_get_all_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pd_get_all_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>
