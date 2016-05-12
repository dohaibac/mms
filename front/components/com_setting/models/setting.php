<?php
defined('BASEPATH') or die;
class SettingModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'setting';
    
    parent::__construct($app, $this->model_name);
  }
}
?>