<?php
defined('BASEPATH') or die;

class MessageQueueHelper
{
  protected $app = '';
  protected $system_code = '';
  
  public function __construct($app, $system_code) {
    $this->app = $app;
    $this->system_code = $system_code;
    
    require_once PATH_COMPONENT .'/com_messagequeue/models/messagequeue.php';
    
    $this->messagequeue_model = new MessagequeueModel($app);
    
    $this->db = JBase::getDbo();
  }

  /***
   * insert message queue
   * 
   * **/
  function insert_messagequeue ($data) {
     $message_id = $data['message_id'];
     $title = $data['title'];
     $message = $data['message'];
     $status = $data['status'];
     $gcm_regid = $data['gcm_regid'];
     $system_code = $data['system_code'];
     $user_id = $data['user_id'];
     $type = $data['type'];
     
     $created_at = date('Y-m-d h:i:s');
     $created_by = '1';
     
     $message = array(
        'message_id' => $message_id,
        'title' => $title,
        'message' => $message,
        'status' => $status,
        'gcm_regid' => $gcm_regid,
        'system_code' => $system_code,
        'user_id' => $user_id,
        'created_at'=> $created_at,
        'created_by'=> $created_by,
        'type'=>$type
      );
      
      $this->messagequeue_model->post($message);
  }
  
}
?>