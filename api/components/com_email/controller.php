<?php
defined('BASEPATH') or die;

class EmailController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/email.php';
    
    $this->email_model =  new EmailModel($this->app);
  }
   
  /***
   * Send mail
   * 
   * 
   * 
   * */
  public function index () {
    $body = $this->get_request_body();
    
    $fromName = $body['fromName'];
    $email = $body['to'];
    $subject = $body['subject'];
    $body = $body['body'];
    
    $result = $this->email_model->send_mail($email, $subject, $body, $fromName);
    
    $ret= $this->message(0, 'email_sent_success', 'Email has been sent.');
    $ret['result'] = $result;
    $this->renderJson($ret);
  }
}
?>