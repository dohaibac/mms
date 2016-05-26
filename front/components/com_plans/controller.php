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
    
    $db = $this->app->getDbo();

    $where = '';
    $order_by ='task_date ASC';
    
    $data = array(
      'where' => $where,
      'user' => 1,
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
  
  public function view () {

  }
  
  public function add() {
    
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
}
?>
