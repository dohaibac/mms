<?php
defined('BASEPATH') or die;

class JobsAlert
{
  protected $app = '';
  protected $system_code = '';
  
  public function __construct($app, $system_code) {
    $this->app = $app;
    $this->system_code = $system_code;
    
    require_once PATH_COMPONENT .'/com_setting/models/setting.php';
    require_once PATH_COMPONENT .'/com_pd/models/pd.php';
    require_once PATH_COMPONENT .'/com_gd/models/gd.php';
    require_once PATH_COMPONENT .'/com_sponsor/models/sponsor.php';
    require_once PATH_COMPONENT .'/com_sponsorinvest/models/sponsorinvest.php';
    require_once PATH_COMPONENT .'/com_systemcode/models/systemcode.php';
    require_once PATH_COMPONENT .'/com_planpd/models/planpd.php';
    require_once PATH_COMPONENT .'/com_pdex/models/pdex.php';
    require_once PATH_COMPONENT .'/com_planget/models/planget.php';
    
    $this->setting_model = new SettingModel($app);
    $this->pd_model = new PdModel($app);
    $this->gd_model = new GdModel($app);
    $this->sponsor_model = new SponsorModel($app);
    $this->sponsorinvest_model = new SponsorinvestModel($app);
    $this->systemcode_model = new SystemcodeModel($app);
    $this->planpd_model = new PlanpdModel($app);
    $this->planget_model = new PlangetModel($app);
    
    $this->pdex_model = new PdexModel($app);
    
    $this->db = JBase::getDbo();
  }
  
  /***
   * Lay danh sach plan PD trong ngay ma chua xac nhan
   * 
   * 
   * **/
  public function alert_plan_pd() {
    $db = JBase::getDbo();
    $system_code = $this->system_code;
    
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d 23:59:59');
    
    $where = 'system_code = ' . $db->quote($system_code) . 
    ' AND (created_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')' .
    ' AND status = 0';
    
    $order_by ='created_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
     
    $data = $this->planpd_model
      ->get_all($data)
      ->body;
    
    $planpds = $data->planpds;
    
    
  }
}
?>