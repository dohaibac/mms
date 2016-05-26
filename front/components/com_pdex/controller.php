<?php
defined('BASEPATH') or die;

class PdexController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/pdex.php';
    require_once PATH_COMPONENT . '/com_pd/models/pd.php';
   
    $this->pdex_model =  new PdexModel($this->app);
    $this->pd_model =  new PdModel($this->app);
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
        $ret = $this->message(1, 'pdex-message-required_'. $field, $this->app->lang('pdex-message-required_' . $field));
        $this->renderJson($ret);
      }
    }
   $system_code = $this->system_code();
   $id = $body['id'];
   $pd_id = $body['pd_id'];
   $sponsor = $body['sponsor'];
   
   // update table pdex : updated_at and status
   $pdex = array(
      'id' => $id,
      'sponsor' => $sponsor,
      'system_code' => $system_code,
      'status' => 1,
      'updated_at'=> date('Y-m-d h:i:s'),
      'updated_by'=>$this->app->user->data()->id
   );
    
   $ret = $this->pdex_model->put($pdex);
   
   // update updated_at trong table pds
   $pd = array(
      'id' => $pd_id,
      'sponsor' => $sponsor,
      'system_code' => $system_code,
      'status' => 2,
      'updated_at'=> date('Y-m-d h:i:s'),
      'updated_by'=>$this->app->user->data()->id
   );
    
    $ret = $this->pd_model->put($pd);
    $data = $ret->body;
    $ret = $this->message($data->type, $data->code, $this->app->lang($data->code));
    $this->renderJson($ret);
  }
}
?>
