<?php
defined('BASEPATH') or die;

class MessageController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/message.php';
    
    $this->message_model =  new MessageModel($this->app);
  }

}
?>