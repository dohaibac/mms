<?php
defined('BASEPATH') or die;

class GdController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/gd.php';
    $this->gd_model =  new GdModel($this->app);

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
      $id = $this->getSafe('id', 0);
      $system_code = $this->getSafe('system_code', '');
      
      if (empty($id)) {
        $ret = $this->message(1, 'gd_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->gd_model->get_by_id($id, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'gd_view_not_found', 'PD does not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('gd_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gd_view_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Insert pd
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
       if (empty($body)) {
         $ret = $this->message(1, 'gd_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'code', 'sponsor', 'amount', 'wallet', 'issued_at', 
         'num_days_gd_pending',
         'num_days_gd_pending_verification', 
         'num_days_gd_approve',  
         'system_code', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'gd_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $system_code = $body['system_code'];
       
       // kiem tra xem pd da ton tai chua
       $exist = $this->gd_model->get_by_code($body['code'], $system_code);
       
       if (isset($exist) && isset($exist->id)) {
         $ret = $this->message(1, 'gd_insert_exist', 'Gd already existed.');
       
         $this->renderJson($ret);
       }
       
       $inserted_id = $this->gd_model->insert($body);
       
       $ret = $this->message(0, 'gd_insert_success', 'Insert gd successfully.');
       
       $ret['data'] = array('gd_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('gd_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'gd_insert_exception', $ex->getMessage());
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
         $ret = $this->message(1, 'gd_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $exist = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $exist = $this->gd_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'gd_update_missing_gd_id', 'Missing user bank id.');
        $this->renderJson($ret);
      }
  
      if (isset($exist) && !empty($exist->id)) {
        // validate data
        
        # list required fields:
        $required_fields = array (
         'code', 'sponsor', 'amount', 'wallet', 'issued_at', 
         'num_days_gd_pending',
         'num_days_gd_pending_verification', 
         'num_days_gd_approve',  
         'system_code', 'created_at', 'created_by'
        );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'gd_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'gd_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'gd_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        // valid unique key
        if (isset($body['code'])) {
          $check_exist_name = $this->gd_model->get_gd_by_code_and_dif_id($body['code'], $exist->id);
          
          if (isset($check_exist_name) && !empty ($check_exist_name->id)) {
            $ret = $this->message(1, 'gd_update_exist', 'Pd already exist.');
            $this->renderJson($ret);
          }
        }
        
        $this->gd_model->update_by_id($body);
        
        $ret = $this->message(0, 'gd_update_success', 'Update Pd has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'gd_update_does_not_exist', 'Pd does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('gd_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gd_update_exception', $ex->getMessage());
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
        $usergroup = $this->gd_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'gd_delete_missing_gd_id', 'Missing pd id.');
        $this->renderJson($ret);
      }
      
      if (isset($usergroup) && !empty($usergroup->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->gd_model->delete_by_id($body);
          $ret = $this->message(0, 'gd_delete_success', 'Delete Gd has been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'gd_delete_gd_not_found', 'Gd not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('gd_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gd_delete_exception', $ex->getMessage());
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

      if (empty($sponsor_owner)) {
        $ret = $this->message(1, 'sponsor_get_by_username_missing_username', 'Missing or Empty username.');
        $this->renderJson($ret);
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
      
      $gd_list = $this->gd_model->get_list($data);
      $total_user_gd_list = $this->gd_model->get_list_total($where);
      
      $ret = array (
        'gds' => $gd_list,
        'total' => $total_user_gd_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('gd_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'gd_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
  
  /***
   * get total in each status of GD 
   * 
   * */
  public function get_status() {
    try {

      $db = $this->app->getDbo();

      $gd_status = $this->gd_model->get_status();

      $ret = array (
        'gds' => $gd_status,
      );

      $this->renderJson($ret);

     } catch (Exception $ex) {
       $this->app->write_log('pd_get_status_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pd_get_status_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }

   /***
   * get all by status, status = 1,2,3
   * 
   * */
  public function get_all() {
    try {

      $db = $this->app->getDbo();

      $gds = $this->gd_model->get_all($this->data);

      $ret = array (
        'gds' => $gds,
      );

      $this->renderJson($ret);

     } catch (Exception $ex) {
       $this->app->write_log('pdex_get_all_by_status_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pdex_get_all_by_status_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>
