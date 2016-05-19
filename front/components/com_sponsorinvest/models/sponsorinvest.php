<?php
defined('BASEPATH') or die;
class SponsorinvestModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'sponsorinvest';
    
    parent::__construct($app, $this->model_name);
  }
  
  public function get_all($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/all';
    
    return $rest_client->get($path, $data);
  }
}
?>