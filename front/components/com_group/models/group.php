<?php
defined('BASEPATH') or die;
class GroupModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'group';
    
    parent::__construct($app, $this->model_name);
  }
 
}
?>