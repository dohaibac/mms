<?php
defined('BASEPATH') or die;

class JobsController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once PATH_COMPONENT . '/com_pd/models/pd.php';
    require_once PATH_COMPONENT . '/com_gd/models/gd.php';
    require_once PATH_COMPONENT . '/com_message/models/message.php';
    
    require_once __DIR__ . '/helper.php';
    
    $system_code = '06';
    
    $this->helper = new JobsHelper($this->app, $system_code);
    
  }

  /***
   * Tinh toan xem co bao nhieu PD trong ngay
   * 
   * Can cu vao thoi gian So ngay cho PD : num_days_pd_pending
   * 
   * **/
  public function get_pd_in_day() {
    $this->helper->get_list_pd_in_day();
  }
  
  /*****
   * Function tao PD trong ngay
   * 
   * */
  public function create_plan_pd() {
    $this->helper->create_plan_pd();
  }
  
  
  /****
   * Tu dong set trang thai PD ve done
   * 
   * **/
  public function set_pd_status_to_done () {
    $this->helper->set_pd_status_to_done();
  }
  
  /****
   * Tu dong set trang thai GD ve done
   * 
   * **/
  public function set_get_to_gd () {
    $this->helper->set_get_to_gd();
  }
  
 /****
   * Tu dong set trang thai GD ve done
   * 
   * **/
  public function set_gd_to_done () {
    $this->helper->set_gd_to_done();
  }
  
  /****
   * Insert danh sach plan_pd vao queue
   * 
   * **/
  public function alert_plan_pd () {
    require_once PATH_COMPONENT . '/com_jobs/alert.php';
    $system_code = '06';
    $alert = new JobsAlert($this->app, $system_code);
    
    $alert->alert_plan_pd();
  }
  
  /****
   * Insert danh sach pd thuc te vao queue
   * 
   * **/
  public function alert_pd () {
    require_once PATH_COMPONENT . '/com_jobs/alert.php';
    $system_code = '06';
    $alert = new JobsAlert($this->app, $system_code);
    
    $alert->alert_pd();
  }
  
   /****
   * Insert danh sach plan_pd vao queue
   * 
   * **/
  public function alert_plan_get () {
    require_once PATH_COMPONENT . '/com_jobs/alert.php';
    $system_code = '06';
    $alert = new JobsAlert($this->app, $system_code);
    
    $alert->alert_plan_get();
  }
  
  /****
   * Insert danh sach plan_pd vao queue
   * 
   * **/
  public function alert_gd_approve () {
    require_once PATH_COMPONENT . '/com_jobs/alert.php';
    $system_code = '06';
    $alert = new JobsAlert($this->app, $system_code);
    
    $alert->alert_gd_approve();
  }

/****
   * Insert danh sach plan_pd vao queue
   * 
   * **/
  public function send_message () {
    require_once PATH_COMPONENT . '/com_message/helper.php';
    
    $system_code = '06';
    
    $helper = new MessageHelper($this->app, $system_code);
    
    $helper->send_message();
  }
}
?>