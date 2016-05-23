<?php
defined('BASEPATH') or die;

class PlansModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__plans';
    
    parent::__construct($app);
  }

  /***
   * Lay thong tin code
   * */
  public function get_by_code ($code, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('code=' . $db->quote($code) . ' AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  /***
   * Lay thong tin plans theo id
   * */
  public function get_plans_by_code_and_dif_id ($code, $id) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('code=' . $db->quote($code) . ' AND id <> ' . $db->quote($id));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }

  /***
   * Lay danh sach plans
   * 
   * $data array
   *   - limit
   *   - page_number
   *   - where: condition
   * */
  public function get_list($data) {
    $start_index = $data['start_index'];
    $limit = $data['limit'];
    $where = $data['where'];
    $order_by = $data['order_by'];
    
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name));
   
    if (!empty($where)) {
      $query->where($where);
    }
    if (!empty($order_by)) {
      $query->order($order_by);
    }
   
    $db->setQuery($query, $start_index, $limit);
    
    return $db->loadAssocList();
  }
  
   /***
   * get all provinces
   * 
   * */
  public function get_provinces() {    
    $db = $this->app->getDbo();
    
    $select = "id, name";
    
    $query = $db->getQuery(true)
      ->select($select)
      ->from($db->quoteName('provinces'));
    
    $db->setQuery($query);
    
    return $db->loadAssocList();
  }
}
?>
