<?php
defined('BASEPATH') or die;
class PdModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'pd';
    
    parent::__construct($app, $this->model_name);
  }
}
?>