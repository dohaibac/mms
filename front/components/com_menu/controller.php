<?php
defined('BASEPATH') or die;

class MenuController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/menu.php';
    
    $this->menu_model =  new MenuModel($this->app);
  }
  
  /***
   * Type Ajax
   * 
   * */
  public function edit() {
    echo 'aaabc';
  }
}
?>