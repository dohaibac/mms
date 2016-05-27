<?php
defined('BASEPATH') or die;

class MessageHelper
{
  protected $app = '';
  protected $system_code = '';
  
  public function __construct($app, $system_code) {
    $this->app = $app;
    $this->system_code = $system_code;
    
    require_once PATH_COMPONENT .'/com_message/models/message.php';
    require_once PATH_COMPONENT .'/com_messagequeue/models/messagequeue.php';
    require_once PATH_COMPONENT .'/com_gcm/models/gcm.php';
    
    $this->message_model = new MessageModel($app);
    $this->messagequeue_model = new MessagequeueModel($app);
    $this->gcm_model = new GcmModel($app);
    
    $this->db = JBase::getDbo();
  }

  /***
   * insert message
   * 
   * **/
  function insert_message ($data) {
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
        'type' => $type
      );
      
      $this->message_model->post($message);
  }
  
  /***
   * Push message to devices
   * 
   * Doc du lieu trong table message_queue
   * va send xuong device
   * sau khi sent xong thi insert vao table message va xoa trong message_queue
   * 
   * */
  function send_message() {
    $data = array (
      'system_code' => $this->system_code
    );
    
    $ret = $this->messagequeue_model->get_all($data)->body;
    
    $messages = $ret->messages;
    
    foreach($messages as $message) {
      
      $registatoin_ids = $message->gcm_regid;
      //$registatoin_ids = 'eTzCTd5gato:APA91bF8BXpiZKEJchp1BEjdwMWtVHWgITYYE-a-9diXX8deI2VPo5WoPpj3NKFwtJSP_IYwusjmQ6Y6nWlERY0_1VPm28HrNPYsgKk7R6WNbCBLzEX6iAMubI2LVv6DEYD89yLR_-5N';
      $title = $message->title;
      $content = $message->message;
      $message_id = $message->message_id;
      $status = $message->status;
      $user_id = $message->user_id;
      $created_at = $message->created_at;
      $created_by = $message->created_by;
      $type = $message->type;
      
      $data = array(
      'registatoin_ids' => array($registatoin_ids),
      'message' => array(
        'message_id' => $message_id,
        'title' => $title, 
        'content' => $content, 
        'timeStamp' => date('Y-m-d h:i:s'),
        'sound'=>'notification'
      )
    );
    
    $result = $this->gcm_model->send_notification($data)->body;
    $result = json_decode($result->message);
    if ($result->success == 1) {
      //send OK, save vao message table
      $data = array(
        'message_id' => $message_id,
        'title' => $title,
        'message' => $content,
        'status' => $status,
        'gcm_regid' => $registatoin_ids,
        'system_code' => $this->system_code,
        'user_id' => $user_id,
        'created_at'=> $created_at,
        'created_by'=> $created_by,
        'type' => $type
      );
      
      $this->insert_message($data);
      
      $this->messagequeue_model->delete(array('message_id'=> $message_id, 'system_code' => $this->system_code));
     
    }
  }
  
    echo 'Done';
}

}
?>