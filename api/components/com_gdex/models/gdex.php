<?php
defined('BASEPATH') or die;

class GdexModel extends JModelBase {
  
  /***
   * Luu thong tin pd hang ngay
   * 
   * */
  public function __construct($app) {
    $this->model_name = '#__gds';
    
    parent::__construct($app);
  }
  
  public function get_all($data) {
    $system_code = $data['system_code'];
    
    $where = $data['where'];
    $order_by = $data['order_by'];
    
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $model_name = $this->model_name;
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($model_name));
   
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
