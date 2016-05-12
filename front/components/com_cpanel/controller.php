<?php
defined('BASEPATH') or die;

class CpanelController extends JControllerForm 
{
  public function index() {
    $this->renderJson(array('status'=> 'OK'));
  }
}
?>