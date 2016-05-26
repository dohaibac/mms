<?php
defined('BASEPATH') or die;
class MessagequeueModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'messagequeue';
    
    parent::__construct($app, $this->model_name);
  }
}
?>