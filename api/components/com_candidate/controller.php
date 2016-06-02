<?php
defined('BASEPATH') or die;

class CandidateController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/candidate.php';
    
    $this->candidate_model =  new CandidateModel($this->app);
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
        $ret = $this->message(1, 'candidate_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->candidate_model->get_by_id($id, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'candidate_view_not_found', 'Candidate not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('candidate_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'candidate_view_exception', $ex->getMessage());
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
         $ret = $this->message(1, 'candidate_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'system_code', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'candidate_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $system_code = $body['system_code'];
       
       $inserted_id = $this->candidate_model->insert($body);
       
       $ret = $this->message(0, 'candidate_insert_success', 'Insert candidate has been successfully.');
       
       $ret['data'] = array('candidate_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('candidate_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'candidate_insert_exception', $ex->getMessage());
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
         $ret = $this->message(1, 'candidate_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $candidate = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $candidate = $this->candidate_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'candidate_update_missing_candidate_id', 'Missing user bank id.');
        $this->renderJson($ret);
      }
  
      if (isset($candidate) && !empty($candidate->id)) {
       # list required fields:
         $required_fields = array (
           'system_code', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'candidate_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'candidate_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'candidate_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        $this->candidate_model->update_by_id($body);
        
        $ret = $this->message(0, 'candidate_update_success', 'Update candidate has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'candidate_update_does_not_exist', 'Candidate not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('candidate_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'candidate_update_exception', $ex->getMessage());
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
      
      $candidate = new stdClass;
      
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $candidate = $this->candidate_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'candidate_delete_missing_candidate_id', 'Missing candidate id.');
        $this->renderJson($ret);
      }
      
      if (isset($candidate) && !empty($candidate->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->candidate_model->delete_by_id($body);
          $ret = $this->message(0, 'candidate_delete_success', 'Delete candidate has been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'candidate_delete_candidate_not_found', 'Candidate not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('candidate_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'candidate_delete_exception', $ex->getMessage());
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
      $province_id = $this->getSafe('province_id', 0);
      
      $page_number = empty($page_number) ? 1 : $page_number;
      
      $start_index = ($page_number -1) * $limit;
      
      $db = $this->app->getDbo();
      
      $search = '';
      
      if (!empty($keywords)) {
        $keywords = $db->quote('%' . $keywords . '%');
        // search theo name
        $search .= $db->quoteName('display_name') . ' LIKE ' . $keywords;
      }
      
      if (!empty ($where)) {
        if (!empty ($search)) {
          $where .= ' AND (' . $search . ')';
        }
        if ($province_id != 0){
          $where .= ' AND (province_id = ' . $province_id . ')';
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

      $candidate_list = $this->candidate_model->get_list($data);
      
      $total_candidate_list = $this->candidate_model->get_list_total($where);
      
      $ret = array (
        'candidates' => $candidate_list,
        'total' => $total_candidate_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('candidate_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'candidate_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>
