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
}
?>