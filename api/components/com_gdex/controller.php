<?php
defined('BASEPATH') or die;

class GdexController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/gdex.php';
    
    $this->gdex_model =  new GdexModel($this->app);
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
   * Inser pd
   * */
  public function insert_multi() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
       if (empty($body)) {
         $ret = $this->message(1, 'pdex_insert_multi_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'sponsor', 'system_code', 'created_at', 'created_by'
       );
       
       $rows = $body['rows'];
       
       foreach($rows as $row) {
         foreach ($required_fields as $key) {
          if (!isset($row[$key]) || empty ($row[$key])) {
            $ret = $this->message(1, 'pdex_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
         }
       }
       
       $this->pdex_model->insert_multi($body);
       
       $ret = $this->message(0, 'pdex_insert_success', 'Insert pdex successfully.');
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('pdex_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'pdex_insert_exception', $ex->getMessage());
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
         $ret = $this->message(1, 'pdex_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $exist = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $exist = $this->pdex_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'pdex_update_missing_pdex_id', 'Missing id.');
        $this->renderJson($ret);
      }
  
      if (isset($exist) && !empty($exist->id)) {
        // validate data
        
        # list required fields:
        $required_fields = array (
         'code', 'sponsor', 'amount', 'issued_at', 'system_code', 'created_at', 'created_by'
        );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'pdex_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'pdex_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'pdex_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        $this->pdex_model->update_by_id($body);
        
        $ret = $this->message(0, 'pdex_update_success', 'Update Pd has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'pdex_update_does_not_exist', 'Pd does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('pdex_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pdex_update_exception', $ex->getMessage());
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
        $usergroup = $this->pdex_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'pdex_delete_missing_pdex_id', 'Missing pd id.');
        $this->renderJson($ret);
      }
      
      if (isset($usergroup) && !empty($usergroup->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->pdex_model->delete_by_id($body);
          $ret = $this->message(0, 'pdex_delete_success', 'Delete Pd has been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'pdex_delete_pdex_not_found', 'Pd not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('pdex_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pdex_delete_exception', $ex->getMessage());
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
      
      $pdex_list = $this->pdex_model->get_list($data);
      
      $total_user_pdex_list = $this->pdex_model->get_list_total($where);
      
      $ret = array (
        'pds' => $pdex_list,
        'total' => $total_user_pdex_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('pdex_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pdex_get_list_exception', $ex->getMessage());
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

      $pds = $this->pdex_model->get_all($this->data);

      $ret = array (
        'pds' => $pds,
      );

      $this->renderJson($ret);

     } catch (Exception $ex) {
       $this->app->write_log('pdex_get_all_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'pdex_get_all_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>
