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
  
  public function create_commands() {
    $this->helper->create_commands();
  }
}
?>