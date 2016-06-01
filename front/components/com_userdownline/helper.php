<?php
defined('BASEPATH') or die;

class UserdownlineHelper
{
  public function __construct($app) {
    $this->app = $app;
    
    require_once PATH_COMPONENT .'/com_planpd/models/planpd.php';
    require_once PATH_COMPONENT .'/com_planget/models/planget.php';
    require_once PATH_COMPONENT .'/com_pdex/models/pdex.php';
    
    $this->planpd_model = new PlanpdModel($this->app);
    $this->planget_model = new PlangetModel($this->app);
    $this->pdex_model = new PdexModel($this->app);
  }
  
  /****
   * Tao cac table can thiet:
   * m_plan_pd_xx
   * m_plan_get_xx
   * m_pdex_xx
   * m_getex_xx
   * 
   * **/
  public function create_table_by_new_system_code($new_system_code) {
    $ret = $this->planpd_model->create_table(array('system_code'=>$new_system_code));
    
    $this->planget_model->create_table(array('system_code'=>$new_system_code));
    $this->pdex_model->create_table(array('system_code'=>$new_system_code));
  }
}

?>