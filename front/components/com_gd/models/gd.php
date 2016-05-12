<?php
defined('BASEPATH') or die;
class GdModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'gd';
    
    parent::__construct($app, $this->model_name);
  }
}
?>