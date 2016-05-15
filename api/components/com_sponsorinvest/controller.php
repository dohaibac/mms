<?php
defined('BASEPATH') or die;

class SponsorinvestController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/sponsorinvest.php';
    
    $this->sponsorinvest_model =  new sponsorinvestModel($this->app);
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
   * Inser
   * */
  public function view() {
    try {
      // check get user group theo id
      $sponsor = $this->getSafe('sponsor');
      $system_code = $this->getSafe('system_code', '');
      
      if (empty($sponsor)) {
        $ret = $this->message(1, 'sponsorinvest_view_missing_sponsor', 'Missing or Empty sponsor.');
        $this->renderJson($ret);
      }
      
      if (empty($system_code)) {
        $ret = $this->message(1, 'sponsorinvest_view_missing_system_code', 'Missing or Empty system_code.');
        $this->renderJson($ret);
      }
      
      $ret = $this->sponsorinvest_model->get_by_sponsor($sponsor, $system_code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'sponsorinvest_view_not_found', 'SponsorInvest is not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('sponsorinvest_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsorinvest_view_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser 
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      
       if (empty($body)) {
         $ret = $this->message(1, 'sponsorinvest_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'sponsor', 'system_code'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'sponsorinvest_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
      $inserted_id = $this->sponsorinvest_model->insert($body);
      
      $ret = $this->message(0, 'sponsorinvest_insert_success', 'Insert sponsor invest successfully.');
       
      $ret['data'] = array('inserted_id' => $inserted_id);
       
      $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('sponsorinvest_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'sponsorinvest_insert_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Lay danh sach 
   * 
   * */
  public function get_all() {
    try {
      $system_code = $this->getSafe('system_code');
      
      if (empty($system_code)) {
         $ret = $this->message(1, 'sponsorinvest_get_all_required_system_code', 'Required system_code');
         $this->renderJson($ret);
       }
       
      $sponsorinvest_list = $this->sponsorinvest_model->get_all($system_code);
     
      $ret = array (
        'lst' => $sponsorinvest_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('sponsorinvest_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsorinvest_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }

  public function delete() {
    try {
      $body = $this->get_request_body();
      $sponsor = $body['sponsor'];
      $system_code = $body['system_code'];
      
      if (empty($sponsor)) {
        $ret = $this->message(1, 'sponsorinvest_required_sponsor', 'Required sponsor');
        $this->renderJson($ret);
      }
      
      if (empty($system_code)) {
        $ret = $this->message(1, 'sponsorinvest_required_system_code', 'Required system_code');
        $this->renderJson($ret);
      }
      
      $this->sponsorinvest_model->delete_by_sponsor($sponsor, $system_code);
      $ret = $this->message(0, 'sponsorinvest_delete_success', 'Delete sponsorinvest has been successfully.');
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('sponsorinvest_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'sponsorinvest_delete_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
}
?>