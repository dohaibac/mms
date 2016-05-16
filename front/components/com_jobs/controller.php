<?php
defined('BASEPATH') or die;

class JobsController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once PATH_COMPONENT . '/com_pd/models/pd.php';
    require_once PATH_COMPONENT . '/com_gd/models/gd.php';
    require_once PATH_COMPONENT . '/com_message/models/message.php';
    
    $this->bank_model =  new BankModel($this->app);
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
}
?>