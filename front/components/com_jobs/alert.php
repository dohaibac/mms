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
   * Tao ra danh sach cac ma se PD trong mot ngay
   * 
   * Can cu vao so luong lenh trong mot ngay
   * Can cu vao so luong ma dau tu
   * Can cu theo muc do uu tien, ma moi truoc, ma cu sau, ma cap thap truoc, ma cao sau
   * 
   * Dua vao do sau cua cay ma tinh toan duoc cap do cua ma
   * 
   * 
   * 
   * **/
  public function alert() {
    
    $meta = $this->get_setting();
    
    $num_commands_per_day = $meta->num_commands_per_day;
    
    // lay thong tin ma dau tu
    $data = array(
      'system_code' => $this->system_code
    );
    
    $ret = $this->sponsorinvest_model->get_all($data);
    
    $sponsor_invest_list = $ret->body->lst;
    
    $array_sponsor_invest_list = array();
    
    foreach($sponsor_invest_list as $sponsor) {
      $array_sponsor_invest_list []= $this->db->quote($sponsor->sponsor);
    }
    
    $sponsor_invest_list_string = implode(',', $array_sponsor_invest_list);
    
    $where = 'username IN ('. $sponsor_invest_list_string .')';
    
    $current_page =  1;
    $order_by ='updated_at';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page,
      'limit' => 50000000
    );
     
    $result = $this->sponsor_model
      ->get_list($data)
      ->body;
      
   $sponsors = $result->sponsors;
   
   $data = array();
   
   foreach($sponsors as $sponsor) {
     $obj = new stdClass;
     $obj->id = $sponsor->id;
     $obj->username = $sponsor->username;
     $obj->updated_at = $this->get_updated_at($sponsor_invest_list, $sponsor->username);
     $obj->upline = $sponsor->upline;
     
     $path = explode('>', $sponsor->path);
     $obj->path_len = count($path);
     $data []= $obj;
   }
   
   $data = json_decode(json_encode($data), true);
   
   $data = $this->sort_sponsors($data);
   
   $this->insert_plan_pd($data, $num_commands_per_day);
   
  }
}
?>