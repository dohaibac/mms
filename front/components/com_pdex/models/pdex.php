<?php
defined('BASEPATH') or die;
class PdexModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'pdex';
    
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
  public function insert_multi($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/insert_multi';
    
    return $rest_client->post($path, $data);
  }
}
?>
