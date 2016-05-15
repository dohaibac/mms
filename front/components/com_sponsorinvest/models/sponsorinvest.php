<?php
defined('BASEPATH') or die;
class SponsorinvestModel extends JModelBase {
  public function __construct($app) {
    $this->app = $app;
    $this->model_name = 'sponsorinvest';
    
    parent::__construct($app, $this->model_name);
  }
}
?>