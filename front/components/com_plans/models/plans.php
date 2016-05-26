<?php
defined('BASEPATH') or die;
class PlansModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'plans';
    
    parent::__construct($app, $this->model_name);
  }
  
  /***
  * get_provinces
  * 
  * */
  public function get_provinces() {
    $rest_client = $this->app->getRestClient();
    $path = '/' . $this->model_name . '/provinces';
    return $rest_client->get($path, array());
  }
  
}
?>
