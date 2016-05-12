 <?php
defined('LIBS_PATH') or die;
class JUser extends JObject
{
  protected static $instance;
  
  public static function getInstance()
  {
    if (!is_object(self::$instance)) {
      self::$instance = new JUser();
    }
    return self::$instance;
  }
  
  public function isGuest()
  {
    $user_session = JBase::getSession()->get('user');
    
    return empty($user_session);
  }
  
  public function data()
  {
    return JBase::getSession()->get('user');
  }
  
  public function logout()
  {
    JBase::getSession()->clear('user');
  }
} 