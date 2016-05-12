<?php
defined('BASEPATH') or die;
class MenuModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'menu';
    
    parent::__construct($app, $this->model_name);
  }
}
?>