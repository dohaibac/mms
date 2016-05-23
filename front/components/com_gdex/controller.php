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
  
  public function edit () {
    $this->app->prevent_remote_access();
    
    $list_required_fields = array(
      'sponsor'
    );
    
    $body = $this->get_request_body();
    
    foreach($list_required_fields as $field) {
      if (!isset($body[$field]) || empty($body[$field])) {
        $ret = $this->message(1, 'gdex-message-required_'. $field, $this->app->lang('gdex-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
    
   $system_code = $this->system_code();
   $id = $body['id'];
   $sponsor = $body['sponsor'];
   
   // update table gds : updated_at and status
   $gdex = array(
      'id' => $id,
      'sponsor' => $sponsor,
      'system_code' => $system_code,
      'status' => 3,
      'updated_at'=> date('Y-m-d h:i:s'),
      'updated_by'=>$this->app->user->data()->id
   );
    
   $ret = $this->gd_model->put($gdex)->body;
   
   $this->renderJson($ret);
  }
}
?>
