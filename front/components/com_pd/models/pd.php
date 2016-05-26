<?php
defined('BASEPATH') or die;
class PdModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'pd';
    
    parent::__construct($app, $this->model_name);
  }
  
  /***
  * get_status
  * 
  * */
  public function get_status() {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_status';
    
    return $rest_client->get($path, array());
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
}
?>
