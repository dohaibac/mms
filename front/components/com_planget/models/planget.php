<?php
defined('BASEPATH') or die;
class PlangetModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'planget';
    
    parent::__construct($app, $this->model_name);
  }
  
 /***
  * get_status
  * 
  * */
  public function get_all($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_all';
    
    return $rest_client->get($path, $data);
  }
  
  /***
   * insert setting
   * 
   * */
  public function delete_by_date($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/delete_by_date';
    
    return $rest_client->delete($path, $data);
  }
   /***
   * create_table
   * 
   * */
  public function create_table($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/create_table';
    
    return $rest_client->post($path, $data);
  }
}
?>
