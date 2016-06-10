<?php
defined('BASEPATH') or die;

class SendcodeController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/sendcode.php';
    
    $this->sendcode_model =  new SendcodeModel($this->app);
  }
   
  /***
   * Common function
   * 
   * detect insert, update, delete
   * 
   * */
  public function index () {
    $method = strtoupper($_SERVER['REQUEST_METHOD']);
    
    switch ($method) {
      case 'GET':
        $this->view();
        break;
      case 'POST':
        $this->insert();
        break;
      case 'PUT':
        $this->update();
        break;
      case 'DELETE':
        $this->delete();
        break;
      default:
        break;
    }
  }
  
  /***
   * 
   * */
  public function send_code() {
    try {
      $user_id = $this->getSafe('user_id', 0);
      $email = $this->getSafe('email');
      $send_code = $this->getSafe('send_code', ''); //email or message
      $code = $this->getSafe('code', '');
      
      if (empty($user_id)) {
        $ret = $this->message(1, 'message_send_code_missing_user_id', 'Missing or Empty user_id.');
        $this->renderJson($ret);
      }
      if (empty($send_code)) {
        $ret = $this->message(1, 'message_send_code_missing_send_code', 'Missing or Empty send_code.');
        $this->renderJson($ret);
      }
      if (empty($code)) {
        $ret = $this->message(1, 'message_send_code_missing_code', 'Missing or Empty code.');
        $this->renderJson($ret);
      }
      
      if ($send_code == 'Email') {
        if (empty($email)) {
          $ret = $this->message(1, 'message_send_code_missing_email', 'Missing or Empty email.');
          $this->renderJson($ret);
        }
        
        require_once PATH_COMPONENT . '/com_email/models/email.php';
    
        $this->email_model =  new EmailModel($this->app);
        
        $fromName = 'Help';
        
        $subject = 'Code for login '. $code;
        $body = 'This code will help you to login to HTQT.';
        
        $result = $this->email_model->send_mail($email, $subject, $body, $fromName);
        
        $ret = $this->message(0, 'email_sent_success', 'Email has been sent.');
        
        $this->renderJson($ret);
      }
      else {
        //TODO::
      }
    } catch (Exception $ex) {
       $this->app->write_log('message_send_code_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'message_send_code_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
}
?>