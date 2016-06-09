<?php
defined('BASEPATH') or die;
class SendcodeModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'sendcode';
    
    parent::__construct($app, $this->model_name);
  }
  
  public function send_code($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/send_code';
    
    return $rest_client->get($path, $data);
  }
}
?>