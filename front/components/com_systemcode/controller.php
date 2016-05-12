<?php
defined('BASEPATH') or die;

class SystemcodeController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/systemcode.php';
    
    $this->systemcode_model =  new SystemcodeModel($this->app);
  }
}
?>