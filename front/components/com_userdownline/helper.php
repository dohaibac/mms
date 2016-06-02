<?php
defined('BASEPATH') or die;

class UserdownlineHelper
{
  public function __construct($app) {
    $this->app = $app;
    
    require_once PATH_COMPONENT .'/com_planpd/models/planpd.php';
    require_once PATH_COMPONENT .'/com_planget/models/planget.php';
    require_once PATH_COMPONENT .'/com_pdex/models/pdex.php';
    require_once PATH_COMPONENT .'/com_setting/models/setting.php';
    
    $this->planpd_model = new PlanpdModel($this->app);
    $this->planget_model = new PlangetModel($this->app);
    $this->pdex_model = new PdexModel($this->app);
    $this->setting_model = new SettingModel($this->app);
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
  
  public function create_default_setting($new_system_code) {
    $meta = array( 
      'num_commands_per_day' => 0,
      'num_days_pd_pending' => 30,
      'num_days_pd_transfer' => 3,
      'num_days_gd_pending' => 9,
      'num_days_gd_pending_verification' => 3,
      'num_days_gd_approve' => 3,
      'num_days_pd_next' => 2,
      'percent_rate_days' => 1,
      'percent_hoa_hong' => 10
    );
     
    $data = array(
      'meta' => json_encode($meta),
      'system_code' => $new_system_code,
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
    
    $this->setting_model->post($data);
    
  }
}

?>