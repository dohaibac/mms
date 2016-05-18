<?php
defined('BASEPATH') or die;

class PlanpdModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__plan_pd';
    
    parent::__construct($app);
  }
  
  public function delete_by_date($system_code, $from_date, $to_date) {
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
     ->delete($db->quoteName($this->model_name))
     ->where('system_code=' . $db->quote($system_code) .
     ' AND (created_at BETWEEN ' . $db->quote($from_date) .' AND ' . $db->quote($to_date) .')');
    
    $db->setQuery($query);
     
    return $db->query();
  }
  /***
   * Lay danh sach user bank
   * 
   * $data array
   *   - limit
   *   - page_number
   *   - where: condition
   * */
  public function get_all($data) {
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
}
?>
