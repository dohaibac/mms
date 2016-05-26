<?php
defined('BASEPATH') or die;

class PlansController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/plans.php';
    
    $this->plans_model =  new PlansModel($this->app);
  }

  public function get_list() {
    $this->app->prevent_remote_access();
    
    // kiem tra xem user da co sponsor chua?
    if (empty($this->app->user->data()->sponsor_owner)) {
      $ret = $this->message(1, 'user-message-require_sponsor_owner', $this->app->lang('user-message-require_sponsor_owner'));
      $this->renderJson($ret);
    }
    
    $where = '';
    $order_by ='task_date ASC';
    
    $data = array(
      'where' => $where,
      'user' => $this->app->user->data()->id,
      'order_by' => $order_by
    );
     
    $result = $this->plans_model->get_list($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;

    $this->renderJson($data);
  }
  
  public function add() {
    $this->app->prevent_remote_access();
    $data = [];

    $taskdate = $this->getSafe("taskdate");
    $province = $this->getSafe("province");
    $description = $this->getSafe("description");

    $data["user_id"] = $this->app->user->data()->id;
    $data["content"] = $description;
    $data["province_id"] = $province;
    $data["task_date"] = $taskdate;

    $result = $this->plans_model->post($data);

    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $response = $result->body;

    $this->renderJson($response);
  }
  
  public function delete() {
    
  }
  
    /***
    * Front controller of get provinces of Plans 
    * 
    * */
  
  public function get_provinces() {

    $result = $this->plans_model->get_provinces();
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'plans-message-' . $data->code, $this->app->lang('plans-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }
  
  
      /***
    * Front controller: update status of Plans 
    * 
    * */
  
  public function update_plan_status() {
    $taskid = $this->getSafe("task_id");
    $data["taskid"] = $taskid;
    $result = $this->plans_model->put($data);
    
    if (!isset($result) || empty($result->body)) {
      $ret = $this->message(1, 'common-message-api_update_failed', $this->app->lang('common-message-api_update_failed'));
      $this->renderJson($ret);
    }
    
    $data = $result->body;
    
    if (isset($data->type) && $data->type != 0) {
      $ret = $this->message($data->type, 'plans-message-' . $data->code, $this->app->lang('plans-message-' . $data->code));
      $this->renderJson($ret);
    }
    
    $this->renderJson($data);
  }
}
?>
