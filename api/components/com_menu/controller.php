<?php
defined('BASEPATH') or die;

class MenuController extends JControllerForm 
{
  public function __construct($app) {
    
    parent::__construct($app);
    
    require_once __DIR__ . '/models/menu.php';
    
    $this->menu_model =  new MenuModel($this->app);
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
      // check get user group theo id
      $id = $this->getSafe('id', 0);
      
      if (empty($id)) {
        $ret = $this->message(1, 'menu_view_missing_id', 'Missing or Empty id.');
        $this->renderJson($ret);
      }
      
      $ret = $this->menu_model->get_by_id($id);
     
      if (empty($ret)) {
        $ret = $this->message(1, 'menu_view_not_found', 'Menu is not exist.');
      }
      
      $this->renderJson($ret);
    } catch (Exception $ex) {
       $this->app->write_log('menu_view_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'menu_view_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * Inser user group
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
       * name
       * ord 
       * created_at
       * created_by
       * 
       * */
       
       if (empty($body)) {
         $ret = $this->message(1, 'menu_insert_empty_data', 'Empty data.');
         $this->renderJson($ret);
       }
       
       $required_fields = array (
         'name', 'ord', 'created_at', 'created_by'
       );
       
       foreach ($required_fields as $key) {
          if (!isset($body[$key]) || empty ($body[$key])) {
            $ret = $this->message(1, 'menu_insert_missing_' . $key, 'Missing or Empty ' . $key);
            $this->renderJson($ret);
          }
       }
       
       $inserted_id = $this->menu_model->insert($body);
       
       $ret = $this->message(0, 'menu_insert_success', 'Insert user group successfully.');
       
       $ret['data'] = array('menu_id' => $inserted_id);
       
       $this->renderJson($ret);
       
     } catch (Exception $ex) {
       $this->app->write_log('menu_insert_exception - ' . $ex->getMessage());
       $ret = $this->message(1, 'menu_insert_exception', EXCEPTION_ERROR_MESSAGE);
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
         $ret = $this->message(1, 'menu_update_empty_data', 'Empty data.');
         $this->renderJson($ret);
      }
      
      $menu = new stdClass;
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $menu = $this->menu_model->get_by_id($body['id']);
      }
      else {
        $ret = $this->message(1, 'menu_update_missing_menu_id', 'Missing menu id.');
        $this->renderJson($ret);
      }
  
      if (isset($menu) && !empty($menu->id)) {
        // update usergroup
        // validate data
        
        # list required fields:
         $required_fields = array (
           'name', 'ord', 'created_at', 'created_by'
         );
         
        // required updated_at and updated_by
        if (!isset($body['updated_at']) || empty($body['updated_at'])) {
          $ret = $this->message(1, 'menu_update_updated_at', 'Missing or Empty updated_at.');
          $this->renderJson($ret);
        }
       
        if (!isset($body['updated_by']) || empty($body['updated_by'])) {
          $ret = $this->message(1, 'menu_update_updated_by', 'Missing or Empty updated_by.');
          $this->renderJson($ret);
        }
        
        foreach ($body as $key=>$val) {
          if (in_array($key, $required_fields)) {
            if (empty($body[$key])) {
              $ret = $this->message(1, 'menu_update_empty_' . $key, 'Empty .' . $key);
              $this->renderJson($ret);
            }
          }
        }
        
        $this->menu_model->update_by_id($body);
        
        $ret = $this->message(0, 'menu_update_success', 'Update menu has been successfully.');
        $this->renderJson($ret);
      }
      else {
        $ret = $this->message(1, 'menu_update_does_not_exist', 'Menu is not exist.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('menu_update_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'menu_update_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
    }
  }
  
  /***
   * delete user
   * */
  public function delete() {
    try {
      $body = $this->get_request_body();
      
      $ret = array ();
      
      $menu = new stdClass;
      
      if (isset($body['id']) && !empty($body['id'])) { // update theo id
        $menu = $this->menu_model->get_by_id($body['id']);
      }
      else {
        $ret = $this->message(1, 'menu_delete_missing_menu_id', 'Missing menu id.');
        $this->renderJson($ret);
      }
      
      if (isset($menu) && !empty($menu->id)) {
        if (isset($body['id']) && !empty ($body['id'])) {
          $this->menu_model->delete_by_id($body);
          $ret = $this->message(0, 'menu_delete_success', 'Delete menu have been successfully.');
          $this->renderJson($ret);
        }
      }
      else {
        $ret = $this->message(1, 'menu_delete_menu_not_found', 'Menu  not found.');
        $this->renderJson($ret);
      }
    } catch (Exception $ex) {
       $this->app->write_log('menu_delete_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'menu_delete_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
  
  /***
   * Lay danh sach menu theo paging
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
      
      $menu_list = $this->menu_model->get_list($data);
      
      $total_menu_list = $this->menu_model->get_list_total($where);
      
      $ret = array (
        'menus' => $menu_list,
        'total' => $total_menu_list
      );
      
      $this->renderJson($ret);
      
     } catch (Exception $ex) {
       $this->app->write_log('menu_get_list_exception - ' . $ex->getMessage());
       
       $ret = $this->message(1, 'menu_get_list_exception', EXCEPTION_ERROR_MESSAGE);
       $this->renderJson($ret);
     }
  }
}
?>