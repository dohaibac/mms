<?php
defined('BASEPATH') or die;
class PlanpdModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'planpd';
    
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
  * get_list
  * 
  * */
  public function get_list($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_list';
    
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
