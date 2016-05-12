<?php
defined('BASEPATH') or die;
class GcmModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
  }
  
  /***
   * get group
   * 
   * */
  public function get($data) {
    // TODO: implement cache
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->get('/gcm', $data);
  }
  
   /***
   * update group
   * 
   * */
  public function put($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->put('/gcm', $data);
  }
  
   /***
   * insert group
   * 
   * */
  public function post($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->post('/gcm', $data);
  }
  
   /***
   * insert group
   * 
   * */
  public function delete($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->delete('/gcm', $data);
  }
   /***
   * get list group
   * 
   * */
  public function get_list($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->get('/gcm/list', $data);
  }
  
  /***
   * get list group
   * 
   * */
  public function send_notification($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->post('/gcm/send', $data);
  }
}
?>