<?php
defined('BASEPATH') or die;

class SystemcodeController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/systemcode.php';
    
    $this->systemcode_model =  new SystemcodeModel($this->app);
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
   * View
   * */
  public function view() {
    try {
      // check get user group theo id
      $code = $this->getSafe('code');
      
      if (empty($code)) {
        $ret = $this->message(1, 'systemcode_view_missing_code', 'Missing or Empty code.');
        $this->renderJson($ret);
      }
      
      $ret = $this->systemcode_model->get_by_code($code);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'systemcode_view_not_found', 'System code does not exist.');
      }
      
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('systemcode_view_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'systemcode_view_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
   /***
   * View
   * */
  public function get_latest() {
    try {
      
      $ret = $this->systemcode_model->get_latest();
     
      if (empty($ret)) {
        $ret = $this->message(1, 'systemcode_get_latest_not_found', 'System code does not exist.');
      }
      
      $this->renderJson($ret);
      
    } catch (Exception $ex) {
       $this->app->write_log('systemcode_get_latest_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'systemcode_get_latest_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser
   * */
  public function insert() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      /***
       * validate required fields
       * 
       * List required fields:
       * 
       * code
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'systemcode_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'code', 
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'systemcode_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       // kiem tra xem da ton tai hay chua?
       $exist = $this->systemcode_model->get_by_code($body['code']);
       
       if (isset($exist) && isset($exist->id)) {
         $ret = $this->message(1, 'systemcode_insert_exist', 'System Code already existed.');
       
         $this->renderJson($ret);
       }
       
       $inserted_id = $this->systemcode_model->insert($body);
       
       $ret = $this->message(0, 'systemcode_insert_success', 'Insert user group successfully.');
       
       $ret['data'] = array('systemcode_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('systemcode_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'systemcode_insert_exception', $ex->getMessage());
       $this->renderJson($ret);
    }
  }
  
  /***
   * Lay danh sach user group theo paging
   * 
   * */
  public function get_list() {
    try {
      
      $limit = $this->getSafe('limit', $this->app->appConf->page_size);
      $page_number = $this->getSafe('page_number', 1);
      $where = $this->getSafe('where', '');
      $order_by = $this->getSafe('order_by', '');
      $keywords = $this->getSafe('keywords', '');
      
      $page_number = empty($page_number) ? 1 : $page_number;
      
      $start_index = ($page_number -1) * $limit;
      
      $db = $this->app->getDbo();
      
      $search = '';
      
      if (!empty($keywords)) {
        $keywords = $db->quote('%' . $keywords . '%');
        // search theo name
        $search .= $db->quoteName('name') . ' LIKE ' . $keywords;
      }
      
      if (!empty ($where)) {
        if (!empty ($search)) {
          $where = ' AND (' . $search . ')';
        }
      } else {
        $where = $search;
      }
      
      $data = array (
        'limit' => $limit,
        'start_index' => $start_index,
        'order_by' => $order_by,
        'where' => $where
      );
      
      $systemcode_list = $this->systemcode_model->get_list($data);
      
      $total_user_systemcode_list = $this->systemcode_model->get_list_total($where);
      
      $ret = array (
        'banks' => $systemcode_list,
        'total' => $total_user_systemcode_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('systemcode_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'systemcode_get_list_exception', $ex->getMessage());
       $this->renderJson($ret);
     }
  }
}
?>