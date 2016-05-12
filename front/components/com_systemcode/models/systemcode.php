<?php
defined('BASEPATH') or die;
class SystemcodeModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'systemcode';
    
    parent::__construct($app, $this->model_name);
  }
  
  public function get_latest($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_latest';
    
    return $rest_client->get($path, $data);
  }
}
?>