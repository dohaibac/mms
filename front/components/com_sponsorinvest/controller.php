<?php
defined('BASEPATH') or die;

class SponsorinvestController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/sponsorinvest.php';
 
    $this->sponsorinvest_model =  new SponsorinvestModel($this->app);
  }
  
  public function check_sponsor_invest () {
    $sponsor = $this->getSafe('sponsor');
    
    if (empty($sponsor)) {
      $ret = $this->message(1, 'sponsorinvest-message-required_sponsor', $this->app->lang('Required sponsor.'));
      $this->renderJson($ret);
    }
    
    $system_code = $this->system_code();
    
    $data = array(
      'sponsor'=> $sponsor,
      'system_code' => $system_code
    );
    
    $result = $this->sponsorinvest_model->get($data);
    
    $data = $result->body;
    
    $this->renderJson($data);
  }
  
  public function get_list() {
    $this->app->prevent_remote_access();
    
    $db = $this->app->getDbo();
    
    $system_code = $this->system_code();
    
    $page_number = $this->getSafe('page_number');
    $limit = $this->getSafe('limit');
    $keyword = $this->getSafe('filter');
    
    $where = 'system_code = ' . $db->quote($system_code);
    
    $order_by ='id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$page_number,
      'keyword' => $keyword,
      'limit' => $limit
    );
     
    $data = $this->sponsorinvest_model
      ->get_list($data)
      ->body;
    
    $this->renderJson($data);
  }
}
?>