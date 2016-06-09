<?php
defined('BASEPATH') or die;

class SendcodeController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/sendcode.php';
    
    $this->sendcode_model =  new SendcodeModel($this->app);
  }
}
?>