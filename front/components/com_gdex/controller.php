<?php
defined('BASEPATH') or die;

class GdexController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/gdex.php';
    require_once PATH_COMPONENT . '/com_gd/models/gd.php';
   
    $this->gdex_model =  new GdexModel($this->app);
    $this->gd_model =  new GdModel($this->app);
  }

  public function get_all() {
    $this->app->prevent_remote_access();
    
    $db = JBase::getDbo();
    
    $system_code = $this->system_code();
    
    $from_date = date('Y-m-d');
    $to_date = date('Y-m-d 23:59:59');
    
    $where = 'system_code = ' . $db->quote($system_code) . 
    ' AND (created_at BETWEEN ' . $db->quote($from_date) . ' AND ' . $db->quote($to_date) . ')';
    
    $order_by ='created_at ASC';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'system_code'=>$system_code
    );
     
    $data = $this->pdex_model
      ->get_all($data)
      ->body;
     
    $data->from_date = $from_date;
    
    $this->renderJson($data);
  }
  
}
?>
