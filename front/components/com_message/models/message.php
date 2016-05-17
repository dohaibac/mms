<?php
defined('BASEPATH') or die;
class MessageModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'message';
    
    parent::__construct($app, $this->model_name);
  }
}
?>