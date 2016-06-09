<?php
defined('BASEPATH') or die;

class EmailModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '';
    
    parent::__construct($app);
  }
  
  public function send_mail ($email, $subject, $body, $fromName) {
    require_once PATH_PLUGINS . '/phpmailer/class.phpmailer.php';
    
    $appConf = JAppConf::getInstance();
    
    $username = $appConf->email_user_name;
    $password = $appConf->email_password;
    
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->CharSet="UTF-8";
    $mail->SMTPSecure = 'tls';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = '587';
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 1;
    $mail->From = $username;
    $mail->FromName = $fromName;
    
    $mail->AddAddress($email);
    
    $mail->IsHTML(true);
    
    $mail->Subject    = $subject;
    $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
    $mail->Body       = $body;
   
    return $mail->send();
  }
  
}
?>