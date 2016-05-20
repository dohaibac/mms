<?php
defined('BASEPATH') or die;

class PlanpdController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/planpd.php';
    
    $this->planpd_model =  new PlanpdModel($this->app);
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
        $ret = $this->message(1, 'planpd_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->planpd_model->get_by_id($id, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'planpd_view_not_found', 'PD does not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('planpd_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'planpd_view_exception', $ex->getMessage());
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
         $ret = $this->message(1, 'planpd_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'sponsor', 'system_code', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'planpd_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $inserted_id = $this->planpd_model->insert($body);
       
       $ret = $this->message(0, 'planpd_insert_success', 'Insert pd successfully.');
       
       $ret['data'] = array('planpd_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('planpd_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'planpd_insert_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  
  /***
   * update 
   * 
   * */
  public function update() {
    try {
      $body = $this->get_request_body();
      
      if (empty($body)) {
         $ret = $this->message(1, 'planpd_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      if (!isset($body['id']) || empty($body['id'])) {
        $ret = $this->message(1, 'planpd_update_required_id', 'Required Id.');
         $this->renderJson($ret);
      }
      
      $this->planpd_model->update_by_id($body);
      
      $ret = $this->message(0, 'planpd_update_success', 'Update Pd has been successfully.');
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('planpd_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'planpd_update_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }

  /***
   * delete by date
   * */
  public function delete_by_date() {
    try {
      $body = $this->get_request_body();
      
      $system_code = $body['system_code'];
      $from_date = $body['from_date'];
      $to_date = $body['to_date'];
      
      $this->planpd_model->delete_by_date($system_code, $from_date, $to_date);
      
      $ret = $this->message(0, 'planpd_delete_success', 'Delete Planpd has been successfully.');
      
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('planpd_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'planpd_delete_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
  
  /***
   * Lay danh sach user group theo paging
   * 
   * */
  public function get_all() {
    try {
      
      $where = $this->getSafe('where', '');
      $order_by = $this->getSafe('order_by', '');
      
      $db = $this->app->getDbo();
      
      $data = array (
        'order_by' => $order_by,
        'where' => $where,
        'system_code' => $this->getSafe('system_code')
      );
      
      $planpd_list = $this->planpd_model->get_all($data);
      
      $ret = array (
        'planpds' => $planpd_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('planpd_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'planpd_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>
