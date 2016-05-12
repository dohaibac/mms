<?php
defined('BASEPATH') or die;
class UserdownlineModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'user';
    
    parent::__construct($app, $this->model_name);
  }
}
?>