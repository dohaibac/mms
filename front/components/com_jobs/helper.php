<?php
defined('BASEPATH') or die;

class JobsHelper
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
  public function create_plan_pd() {
    
    $meta = $this->get_setting();
    
    $num_commands_per_day = $meta->num_commands_per_day;
    
    // lay thong tin ma dau tu
    $data = array(
      'system_code' => $this->system_code
    );
    
    $result = $this->sponsor_model
      ->get_sponsor_invest($data)
      ->body;
     
   $sponsors = $result->sponsors;
   
   $data = array();
   
   foreach($sponsors as $sponsor) {
     $obj = new stdClass;
     $obj->id = $sponsor->id;
     $obj->username = $sponsor->username;
     $obj->updated_at = $sponsor->updated_at_invest;
     $obj->upline = $sponsor->upline;
     
     $path = explode('>', $sponsor->path);
     $obj->path_len = count($path);
     $data []= $obj;
   }
   
   $data = json_decode(json_encode($data), true);
   
   $data = $this->sort_sponsors($data);
   
  $ret= $this->insert_plan_pd($data, $num_commands_per_day);
  print_r($ret);
   
  }
  
  function get_updated_at ($sponsors, $username) {
    foreach($sponsors as $sponsor) {
      if ($sponsor->sponsor == $username) {
        return $sponsor->updated_at;
      }
    }
  }
  /***
   * Tao ra so luong ma du kien PD trong ngay
   * 
   * **/
  function insert_plan_pd ($data, $num_commands_per_day) {
    // delete first
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d 23:59:59');
    
    $this->planpd_model->delete_by_date(array(
      'system_code' => $this->system_code,
      'from_date' => $from_date,
      'to_date' => $to_date
    ));
    
    $len = count($data);
    $n = $len > $num_commands_per_day ? $num_commands_per_day : $len;
    
    for ($i = 0; $i < $n; $i ++) {
      $sponsor = $data[$i];
      $plan_pd = array(
        'sponsor' => $sponsor['username'],
        'system_code' => $this->system_code,
        'status' => 0,
        'created_at'=> date('Y-m-d h:i:s'),
        'created_by'=>1
      );
      
      $this->planpd_model->post($plan_pd);
    }
  }
  
   /***
   * Tu dong tao GET
   * 
   * */
  function auto_create_plan_get($sponsor, $amount, $system_code) {
    $sponsor = $sponsor;
    
    $status = 0;
    
    // tinh toan so tien co the get ve
    
    $meta = $this->get_setting();
    
    $num_days_pd_pending = $meta->num_days_pd_pending;
    $percent_rate_days  = $meta->percent_rate_days;
    
    $receive_amount = $amount + ($amount * $num_days_pd_pending) * ($percent_rate_days / 100);
    
    $data = array(
      'sponsor' => $sponsor,
      'amount' => $receive_amount,
      'system_code' => $system_code,
      'status' => $status,
      'created_by' => 1,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    $result = $this->planget_model->post($data);
  }
  
  /***
   * Tu dong tao GET
   * 
   * */
  function auto_create_get($sponsor, $amount, $system_code) {
    $meta = $this->get_setting();
    
    $code = 'GD' . time();
    
    $num_days_pd_pending = $meta->num_days_pd_pending;
    $percent_rate_days = $meta->percent_rate_days;
   
    $wallet = 'R-Wallet';
    $bank = 1;
    $issued_at = date('Y-m-d h:i:s');
    
    $num_days_gd_pending = $meta->num_days_gd_pending;
    $num_days_gd_pending_verification = $meta->num_days_gd_pending_verification;
    $num_days_gd_approve = $meta->num_days_gd_approve;
    
    $status = 1;
    
    $data = array(
      'code' => $code,
      'sponsor' => $sponsor,
      'bank_id' => $bank,
      'amount' =>$amount,
      'wallet' =>$wallet,
      'system_code' => $system_code,
      'issued_at' => $issued_at,
      'num_days_gd_pending' => $num_days_gd_pending,
      'num_days_gd_pending_verification' => $num_days_gd_pending_verification,
      'num_days_gd_approve' => $num_days_gd_approve,
      'status' => $status,
      'auto_set' => 1,
      'created_by' => 1,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    return $this->gd_model->post($data);
  }
  
  function sort_sponsors($data) {
    $updated_at = array();
    $path_len = array();
    
    foreach ($data as $key => $row) {
      $updated_at[$key]  = $row['updated_at'];
      $path_len[$key] = $row['path_len'];
    }
    
    array_multisort($updated_at, SORT_ASC, $path_len, SORT_DESC, $data);
    
    return $data;
  }
  
  /******
   * Lay thong tin setting
   * 
   * @return object
   * 
   * */
  function get_setting () {
    // lay thong tin so lenh trong mot ngay
    $data = array(
      'system_code' => $this->system_code
    );
    
    $result = $this->setting_model->get($data);
    
    $data = $result->body;
    
    $meta = json_decode($data->meta);
    
    return $meta;
  }
  
  /*************************************
   * 
   * Lay danh sach cac Ma can PD trong ngay
   * Can cu vao issued_at va num_days_pd_pending 
   * 
   * ***********************************/
   
   function get_list_pd_in_day () {
     $meta = $this->get_setting();
    
     $num_days_pd_pending = $meta->num_days_pd_pending;
     $num_days_pd_transfer = $meta->num_days_pd_transfer;
     
     // lay danh sach pd pending
     $db = JBase::getDbo();
     
     $total_days_pending = $num_days_pd_pending + $num_days_pd_transfer;
     
     $current_time = time();
     $from_date = date('Y-m-d 00:00:00', strtotime('-'. $total_days_pending .' day', $current_time));
     
     $to_date = date('Y-m-d 23:59:59', strtotime('-'. $num_days_pd_pending .' day', $current_time));
     
     $where = 'system_code = ' . $db->quote($this->system_code) . 
      ' AND (issued_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')' .
      ' AND status=1';
     
     $order_by ='issued_at ASC';
      
      $data = array(
        'where'=>$where,
        'order_by'=>$order_by,
        'system_code'=>$this->system_code
      );
       
      $data = $this->pd_model
        ->get_all($data)
        ->body;
     
     $pds = $data->pds;
     
     $rows = array();
     
     foreach($pds as $pd) {
       $row = array(
        'pd_id' => $pd->id,
        'sponsor' => $pd->sponsor,
        'system_code' =>$this->system_code,
        'status' => 0,
        'created_at'=> date('Y-m-d h:i:s'),
        'created_by'=>1
       );
       $rows []= $row;
     }
     
     if (empty($rows)) {
       return;
     }
     
     $pdexs = array(
        'rows' => $rows,
        'system_code' => $this->system_code
      );
      
    $ret =  $this->pdex_model->insert_multi($pdexs);
    print_r($ret->body);
   }
   
   /***
    * Tu dong set trang thai cua PD ve done khi issued_at vuot qua thoi gian
    * 
    * 
    * 
    * */
   function set_pd_status_to_done() {
     $meta = $this->get_setting();
    
     $num_days_pd_pending = $meta->num_days_pd_pending;
     $num_days_pd_transfer = $meta->num_days_pd_transfer;
     
     // lay danh sach pd pending
     $db = JBase::getDbo();
     
     $total_days_pending = $num_days_pd_pending + $num_days_pd_transfer;
     
     $current_time = time();
     $from_date = date('Y-m-d 00:00:00', strtotime('-'. $total_days_pending .' day', $current_time));
     
     $where = 'system_code = ' . $db->quote($this->system_code) . 
      ' AND issued_at < ' . $db->quote($from_date) .
      ' AND status=2';  // payment pending
     
     $order_by ='issued_at ASC';
      
     $data = array(
        'where'=>$where,
        'order_by'=>$order_by,
        'system_code'=>$this->system_code
     );
       
     $data = $this->pd_model
        ->get_all($data)
        ->body;
     
     $pds = $data->pds;
     
     foreach($pds as $pd) {
       $pd_update = array(
        'id' => $pd->id,
        'system_code' =>$this->system_code,
        'status' => 3,
        'updated_at'=> date('Y-m-d h:i:s'),
        'updated_by'=>1
       );
       
       $ret = $this->pd_model->put($pd_update);
       
       // save xong thi tao luon lenh GET
       $this->auto_create_plan_get($pd->sponsor, $pd->amount, $this->system_code);
     }
   }

/***
    * Tu dong set trang thai cua PD ve done khi issued_at vuot qua thoi gian
    * 
    * 
    * 
    * */
   function set_gd_to_done() {
     $meta = $this->get_setting();
     
     // lay danh sach pd pending
     $db = JBase::getDbo();
    $status = 2;
    
    $num_days_pd_pending = $meta->num_days_pd_pending;
    $num_days_pd_transfer = $meta->num_days_pd_transfer;
    $num_days_gd_pending = $meta->num_days_gd_pending;
    $num_days_gd_pending_verification = $meta->num_days_gd_pending_verification;
     
    $total = $num_days_pd_pending + $num_days_pd_transfer + $num_days_gd_pending + $num_days_gd_pending_verification;
    
    $current_time = time();
    
    $to_date = date('Y-m-d 23:59:59', strtotime('-'. $total .' day', $current_time));
     
    $where = 'system_code = ' . $db->quote($system_code) . 
      ' AND issued_at < ' . $db->quote($to_date) .
      ' AND status=' . $db->quote($status);
     
    $order_by ='issued_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
       
    $data = $this->gd_model
      ->get_all($data)
      ->body;
     $order_by ='issued_at ASC';
      
     $gds = $data->gds;
     
     foreach($gds as $gd) {
       $gd_update = array(
        'id' => $gd->id,
        'system_code' =>$this->system_code,
        'status' => 3,
        'updated_at'=> date('Y-m-d h:i:s'),
        'updated_by'=>1
       );
       
       $ret = $this->gd_model->put($gd_update);
     }
   }
}
?>