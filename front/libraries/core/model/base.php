<?php
 defined('LIBS_PATH') or die; 
 abstract class JModelBase {
  protected $app = null; 
  protected $model_name = '';
  
  public function __construct($app, $model_name='') {
    $this->app = $app;
    $this->model_name = $model_name;
  }
   /***
   * get setting
   * 
   * */
  public function get($data) {
    // TODO: implement cache
    
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name;
    
    return $rest_client->get($path, $data);
  }
  
   /***
   * update setting
   * 
   * */
  public function put($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name;
    
    return $rest_client->put($path, $data);
  }
  
   /***
   * insert setting
   * 
   * */
  public function post($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name;
    
    return $rest_client->post($path, $data);
  }
  
   /***
   * insert setting
   * 
   * */
  public function delete($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name;
    
    return $rest_client->delete($path, $data);
  }
   /***
   * get list setting
   * 
   * */
  public function get_list($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/list';
    
    return $rest_client->get($path, $data);
  }
  
  /***
   * get list setting
   * 
   * */
  public function get_all($data) {
    $rest_client = $this->app->getRestClient();
    
    $path = '/' . $this->model_name . '/get_all';
    
    return $rest_client->get($path, $data);
  }
  
 } ?>