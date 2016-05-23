<?php
defined('BASEPATH') or die;

class MessagequeueController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/messagequeue.php';
    
    $this->messagequeue_model =  new MessagequeueModel($this->app);
  }

}
?>