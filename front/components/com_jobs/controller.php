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
  
  public function update_pd_status() {
    
  }
  
  public function update_gd_status() {
    
  }
  
  /***
   * Dua vao thong tin tinh toan se push message
   * 
   * */
  public function create_message() {
    
  }
  
  /***
   *  Nhac co lenh PD
      Nhac GET
      Nhac co lenh GD
      Nhac lenh approve
   * 
   * **/
  public function alert() {
    
  }
  
  public function create_commands() {
    $this->helper->create_commands();
  }
}
?>