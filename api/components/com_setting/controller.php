<?php
defined('BASEPATH') or die;

class SettingController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/setting.php';
    
    $this->setting_model =  new SettingModel($this->app);
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
   * Inser user group
   * */
  public function view() {
    try {
      $system_code = $this->getSafe('system_code', '');
      
      $ret = $this->setting_model->get_setting_by_system_code($system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'setting_view_not_found', 'Setting not found.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('setting_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'setting_view_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser user group
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      
       if (empty($body)) {
         $ret = $this->message(1, 'setting_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'meta', 'system_code', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'setting_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $system_code = $body['system_code'];
       
       // kiem tra xem setting da ton tai hay chua?
       $exist = $this->setting_model->get_setting_by_system_code($system_code);
       
       if (isset($exist) && isset($exist->id)) {
         $ret = $this->message(1, 'setting_insert_exist', 'Setting already existed.');
       
         $this->renderJson($ret);
       }
       
       $inserted_id = $this->setting_model->insert($body);
       
       $ret = $this->message(0, 'setting_insert_success', 'Insert setting successfully.');
       
       $ret['data'] = array('setting_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('setting_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'setting_insert_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * update user
   * */
  public function update() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      if (empty($body)) {
         $ret = $this->message(1, 'setting_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $setting = new stdClass;
      $system_code = $body['system_code'];
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $setting = $this->setting_model->get_by_id($body['id'], $system_code);
      }
      else {
        $ret = $this->message(1, 'setting_update_missing_setting_id', 'Missing setting id.');
        $this->renderJson($ret);
      }
  
      if (isset($setting) && !empty($setting->id)) {
        // update usergroup
        // validate data
        
        # list required fields:
         $required_fields = array (
           'meta', 'system_code', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'setting_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'setting_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'setting_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        $this->setting_model->update_by_id($body);
        
        $ret = $this->message(0, 'setting_update_success', 'Update setting has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'setting_update_does_not_exist', 'Setting does not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('setting_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'setting_update_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
}
?>