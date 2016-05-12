<?php
defined('BASEPATH') or die;
class BankModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'bank';
    
    parent::__construct($app, $this->model_name);
  }
}
?>