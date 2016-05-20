<?php
defined('BASEPATH') or die;

class PdexModel extends JModelBase {
  
  /***
   * Luu thong tin pd hang ngay
   * 
   * */
  public function __construct($app) {
    $this->model_name = '#__pdex';
    
    parent::__construct($app);
  }
  
  /***
   * Insert multi data
   * 
   * $data array
   * 
   * 
   * @return integer
   * */
  public function insert_multi($data) {
    $db = $this->app->getDbo();
    $query = $db->getQuery(true);
    
    $system_code = $data['system_code'];
    $model_name = $this->model_name . '_' . $system_code;
    
    $query->insert($db->quoteName($model_name));
    
    $rows = $data['rows'];
    
    $columns = $this->build_columns_list_multi($rows);
    
    $query->columns($db->quoteName($columns));
    
    foreach($rows as $row) {
      $value = $this->build_columns_value($row, $db);
      
      $query->values(implode(',', $value));
    }
    
    $db->setQuery($query);
    $db->query();
  }
  
  public function get_all($data) {
    $system_code = $data['system_code'];
    
    $where = $data['where'];
    $order_by = $data['order_by'];
    
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $model_name = $this->model_name . '_' . $system_code;
    
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
  
  /***
   * Lay thong tin theo id
   * */
  public function get_by_id ($id, $system_code) {
    
    $model_name = $this->model_name . '_'. $system_code;
    
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($model_name))
     ->where('id=' . $db->quote($id) . ' AND ' . 'system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  /***
   * Update by id
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function update_by_id($data) {
    if (!isset($data['id'])) {
      return false;
    }
    
    $system_code = $data['system_code'];
    
    $model_name = $this->model_name . '_'. $system_code;
    
    $object = $this->generate_object_update($data);
    
    $db = $this->app->getDbo();
    
    $db->updateObject($model_name, $object, 'id');
  }
}
?>
