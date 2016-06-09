<?php
defined('BASEPATH') or die;
class UserModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'user';
    
    parent::__construct($app, $this->model_name);
  }
  
  public function get_by_user_name($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_by_username';
    
    return $rest_client->get($path, $data);
  }
  public function get_by_email($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_by_email';
    
    return $rest_client->get($path, $data);
  }
  public function get_by_group_id($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_by_group_id';
    
    return $rest_client->get($path, $data);
  }
  
 /***
   * enable password2
   * 
   * */
  public function enable_password2($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/enable_password2';
    
    return $rest_client->put($path, $data);
  }
  
}
?>