<?php
defined('BASEPATH') or die;

class PlansModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__plans';
    
    parent::__construct($app);
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

    $db->setQuery($query);
    
    return $db->loadAssocList();
  }
  
   /***
   * get all provinces
   * 
   * */
  public function provinces() {    
    $db = $this->app->getDbo();
    
    $select = "id, name";
    
    $query = $db->getQuery(true)
      ->select($select)
      ->from($db->quoteName('#__provinces'));
   
    $db->setQuery($query);
    
    return $db->loadAssocList();
  }
}
?>
