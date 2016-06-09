<?php
defined('BASEPATH') or die;

class SendcodeModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__sendcode';
    
    parent::__construct($app);
  }
}
?>