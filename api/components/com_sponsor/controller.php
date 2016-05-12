<?php
defined('BASEPATH') or die;

class SponsorController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/sponsor.php';
    
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
        $ret = $this->message(1, 'sponsor_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->sponsor_model->get_by_id($id, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'sponsor_view_not_found', 'Sponsor does not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_view_exception', $ex->getMessage());
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
       * username
       * name
       * email
       * mobile
       * parent_id
       * upline
       * system_code
       * 
       * created_at
       * created_by
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'sponsor_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'name', 'username', 'email', 'mobile', 'system_code', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'sponsor_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $system_code = $body['system_code'];
       
       // kiem tra xem sponsor da ton tai hay chua?
       $sponsor = $this->sponsor_model->get_by_username($body['username']);
       
       if (isset($sponsor) && isset($sponsor->id)) {
         $ret = $this->message(1, 'sponsor_insert_exist', 'Sponsor already existed.');
       
         $this->renderJson($ret);
       }
       
       $inserted_id = $this->sponsor_model->insert($body);
       
       $ret = $this->message(0, 'sponsor_insert_success', 'Insert sponsor successfully.');
       
       $ret['data'] = array('sponsor_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('sponsor_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'sponsor_insert_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * update sponsor
   * */
  public function update() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      if (empty($body)) {
         $ret = $this->message(1, 'sponsor_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $bank = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $bank = $this->sponsor_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'sponsor_update_missing_sponsor_id', 'Missing user bank id.');
        $this->renderJson($ret);
      }
  
      if (isset($bank) && !empty($bank->id)) {
        // update usergroup
        // validate data
        
        # list required fields:
         $required_fields = array (
           'name', 'branch_name', 'account_hold_name', 'account_number', 'linked_mobile_number', 'system_code', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'sponsor_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'sponsor_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'sponsor_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        // valid unique key
        if (isset($body['name'])) {
          $check_exist_name = $this->sponsor_model->get_sponsor_by_name_account_number_and_dif_id($body['name'], $body['account_number'], $bank->id);
          
          if (isset($check_exist_name) && !empty ($check_exist_name->id)) {
            $ret = $this->message(1, 'sponsor_update_exist', 'Bank account number already exist.');
            $this->renderJson($ret);
          }
        }
        
        $this->sponsor_model->update_by_id($body);
        
        $ret = $this->message(0, 'sponsor_update_success', 'Update bank has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'sponsor_update_does_not_exist', 'Bank account does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_update_exception', $ex->getMessage());
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
        $usergroup = $this->sponsor_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'sponsor_delete_missing_sponsor_id', 'Missing bank id.');
        $this->renderJson($ret);
      }
      
      if (isset($usergroup) && !empty($usergroup->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->sponsor_model->delete_by_id($body);
          $ret = $this->message(0, 'sponsor_delete_success', 'Delete bank has been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'sponsor_delete_sponsor_not_found', 'Bank not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_delete_exception', $ex->getMessage());
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
      
      $sponsor_list = $this->sponsor_model->get_list($data);
      
      $total_sponsor_list = $this->sponsor_model->get_list_total($where);
      
      $ret = array (
        'sponsors' => $sponsor_list,
        'total' => $total_sponsor_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('sponsor_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
  
  /***
   * Lay thong tin sponsor dau tien
   * */
  public function get_top_one() {
    try {
      // check get user group theo id
      $system_code = $this->getSafe('system_code', '');
      
      if (empty($system_code)) {
        $ret = $this->message(1, 'sponsor_get_top_one_missing_system_code', 'Missing or Empty system_code.');
        $this->renderJson($ret);
      }
      
      $sponsor = $this->sponsor_model->get_top_one($system_code);
     
      if (empty($sponsor)) {
        $sponsor = new stdClass;
      }
      
      $ret = $this->message(0, 'sponsor_get_top_one_found', 'Found sponsor.');
      $ret['data'] = $sponsor;
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_get_top_one_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_get_top_oneexception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  

  /***
   * Lay sponsor theo username
   * */
  public function get_by_username() {
    try {
      
      $username = $this->getSafe('username', '');
      
      if (empty($username)) {
        $ret = $this->message(1, 'sponsor_get_by_username_missing_username', 'Missing or Empty username.');
        $this->renderJson($ret);
      }
      
      $sponsor = $this->sponsor_model->get_by_username($username);
      
      if (empty($sponsor)) {
        $ret = $this->message(0, 'sponsor_get_by_username_not_found', 'Sponsor does not exist.');
        $ret['data'] = new stdClass;
        $this->renderJson($ret);
      }
      
      $ret = $this->message(0, 'sponsor_get_by_username_found', 'Found sponsor.');
      $ret['data'] = $sponsor;
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_get_by_username_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_get_by_username_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Lay sponsor theo upline
   * 
   * */
  public function get_upline() {
    try {
      // check get user group theo id
      $username = $this->getSafe('username', '');
      $system_code = $this->getSafe('system_code', '');
      
      if (empty($username)) {
        $ret = $this->message(1, 'sponsor_get_upline_missing_username', 'Missing or Empty username.');
        $this->renderJson($ret);
      }
      
      $sponsor = $this->sponsor_model->get_upline($username);
     
      if (empty($sponsor)) {
        $ret = $this->message(1, 'sponsor_get_upline_not_found', 'Sponsor does not exist.');
        $ret['data'] = new stdClass;
        $this->renderJson($ret);
      }
      
      $ret = $this->message(0, 'sponsor_get_upline_found', 'Found sponsor.');
      $ret['data'] = $sponsor;
      
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_get_upline_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_get_upline_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /****
   * Lay danh sach downline cap 1
   * 
   * **/
  public function get_downline_f1() {
    try {
      $upline = $this->getSafe('upline', '');
      $system_code = $this->getSafe('system_code', '');
      
      if (empty($upline)) {
        $ret = $this->message(1, 'sponsor_get_downline_f1_missing_upline', 'Missing or Empty upline.');
        $this->renderJson($ret);
      }
      
      $sponsor_downlines = $this->sponsor_model->get_by_downline_f1($upline);
     
      if (empty($sponsor_downlines)) {
        $sponsor_downlines = array();
      }
      
      $ret = $this->message(0, 'sponsor_get_downline_f1_found', 'Downline f1 found.');
      $ret['data'] = $sponsor_downlines;
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_get_downline_f1_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_get_downline_f1_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }

  public function update_has_fork() {
    try {
      $body = $this->get_request_body();
      
      if (empty($body)) {
         $ret = $this->message(1, 'sponsor_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $username = $body['username'];
      $system_code = $body['system_code'];
      $has_fork = $body['has_fork'];
      
      if (empty($username)) {
         $ret = $this->message(1, 'sponsor_update_required_username', 'Required username.');
         $this->renderJson($ret);
      }
      
      $this->sponsor_model->update_has_fork($username, $has_fork);
        
      $ret = $this->message(0, 'sponsor_update_has_fork_success', 'Update has_fork has been successfully.');
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('sponsor_update_has_fork_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsor_update_has_fork_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
}
?>