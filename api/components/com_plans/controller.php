<?php
defined('BASEPATH') or die;

class PlansController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/plans.php';
    
    $this->plans_model =  new PlansModel($this->app);
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
   *  View a plan
   * */
  public function get_list() {
    try {

      $db = $this->app->getDbo();
      
      $condition = $this->getSafe('where', '');
      $user = $this->getSafe('user', '');
      $order_by = $this->getSafe('order_by', '');
      
      $where = "user_id = " . $user;
      if (!empty($condition)){
        $where .= " AND " . $condition;
      }
      
      $data = array (
        'order_by' => $order_by,
        'where' => $where
      );
      
      $plans_list = $this->plans_model->get_list($data);

      $ret = array (
        'plans_list' => $plans_list,
      );

      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('provinces_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'provinces_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
  
  /***
   * Insert plans
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      $ret = array ();

      if (empty($body)) {
        $ret = $this->message(1, 'Plan_insert_empty_data', 'Empty data.');
        $this->renderJson($ret);
      }
      
      $required_fields = array ('province_id', 'content', 'user_id', 'task_date');
       
      foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'plan_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
      }
       
      $body["taskStatus"] = false;

      $inserted_id = $this->plans_model->insert($body);
      $ret = $this->message(0, 'plan_insert_success', 'Insert Plan successfully.');
      $ret['data'] = array('Plan_id' => $inserted_id);
      $this->renderJson($ret);

    } catch (Exception $ex) {
        $this->app->write_log('plan_insert_exception - ' . $ex->getMessage());
        $ret = $this->message(1, 'plan_insert_exception', $ex->getMessage());
        $this->renderJson($ret);
    }
  }
  
  /***
   * delete plan
   * */
  public function delete() {
    try {
      $body = $this->get_request_body();
      $ret = array ();
      
      $list_tasks = $body["task_list"];

      foreach ($list_tasks as $ids) {
        $plan["id"] = $ids;
        $this->plans_model->delete_by_id($plan);
        $ret = $this->message(0, 'gd_delete_success', 'Delete Gd has been successfully.');
      }

      $this->renderJson($ret);
      
    } catch (Exception $ex) {
      $this->app->write_log('plan_delete_exception - ' . $ex->getMessage());
       
      $ret = $this->message(1, 'plan_delete_exception', $ex->getMessage());
      $this->renderJson($ret);
    }
  }
  
  /***
   * update plan
   * */
  public function update() {
    try {
      $body = $this->get_request_body();
      $ret = array ();
      $plan = array ();
      
      if (empty($body)) {
          $ret = $this->message(1, 'Plan_update_empty_data', 'Empty data.');
          $this->renderJson($ret);
        }
      
      $taskid = $body["taskid"];
      
      $plan = $this->plans_model->get_plan($taskid);
      //print_r($plan);
      //print("status : ". $plan[0]["taskStatus"]);
      //exit;
      if ($plan[0]["taskStatus"] == 1){
        $taskStatus = 0;
      }else{
        $taskStatus = 1;
      }
      
      $plan_body["id"] = $taskid;
      $plan_body["taskStatus"] = $taskStatus;
      
      //$plan_update = $this->plans_model->update_plan_status($taskid, $taskStatus);
      $plan_update = $this->plans_model->update_by_id($plan_body);
      
      $ret = $this->message(0, 'plan_update_success', 'Update Plan successfully.');
      $ret['data'] = array();
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
      $this->app->write_log('Plan_update_exception - ' . $ex->getMessage());
      $ret = $this->message(1, 'Plan_update_exception', $ex->getMessage());
      $this->renderJson($ret);
    }
  }
  
  /***
   * Lay danh sach user group theo paging
   * 
   * */
  public function get_provinces() {
    try {
      
      $db = $this->app->getDbo();
      
      $provinces = $this->plans_model->provinces();

      $ret = array (
        'provinces' => $provinces,
      );

      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('provinces_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'provinces_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>
