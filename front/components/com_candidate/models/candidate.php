<?php
defined('BASEPATH') or die;
class CandidateModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'candidate';
    
    parent::__construct($app, $this->model_name);
  }
}
?>