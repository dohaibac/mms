<?php
defined('BASEPATH') or die;
class SponsorModel extends JModelBase {
 public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'sponsor';
    
    parent::__construct($app, $this->model_name);
  }

  /***
   * get top one sponsor
   * 
   * */
  public function get_top_one($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->get('/sponsor/top_one', $data);
  }
  
   /***
   * get top one sponsor
   * 
   * */
  public function get_by_username($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->get('/sponsor/get_by_username', $data);
  }
  
  /***
   * get downline f1
   * 
   * */
  public function get_downline_f1($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->get('/sponsor/get_downline_f1', $data);
  }
  
  /***
   * get downline f1
   * 
   * */
  public function get_upline($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->get('/sponsor/get_upline', $data);
  }
   /***
   * get top one sponsor
   * 
   * */
  public function insert_bank($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->post('/sponsor/bank', $data);
  }
  
  public function update_has_fork($data) {
    $rest_client = $this->app->getRestClient();
    
    return $rest_client->put('/sponsor/update_has_fork', $data);
  }
}
?>