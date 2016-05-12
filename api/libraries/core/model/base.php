<?php
defined('LIBS_PATH') or die;

abstract class JModelBase
{
  public function __construct($app) {
    $this->app = $app;
  }
  
  /***
   * build list columns khi insert hoac update tu $data
   * 
   * $data array
   * 
   * @return array
   * */
  public function build_columns_list ($data) {
    $column_keys = array ();
    foreach($data as $key=>$val) {
      $column_keys []= $key; 
    }
    
    return $column_keys;
  }
  
  /***
   * build list columns khi insert hoac update tu $data
   * 
   * $data array
   * 
   * @return array
   * */
  public function build_columns_value ($data, $db) {
    $column_vals = array ();
    foreach($data as $key=>$val) {
      $column_vals []= $db->quote($val); 
    }
    
    return $column_vals;
  }
  
  /***
   * generate object update
   * 
   * $data array
   * 
   * @return array
   * */
  public function generate_object_update ($data) {
    $object = new stdClass();
    
    $column_vals = array ();
    foreach($data as $key=>$val) {
      $object->$key = $val; 
    }
    
    return $object;
  }
  
    /***
   * Insert data
   * 
   * $data array
   * 
   * 
   * @return integer
   * */
  public function insert($data) {
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true);
    
    $columns = $this->build_columns_list($data);
    
    $values = $this->build_columns_value($data, $db);
    
    // Prepare the insert query.
    $query
        ->insert($db->quoteName($this->model_name))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));
     
    
    $db->setQuery($query);
    $db->query();
    
    return $db->insertid();
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
    
    $object = $this->generate_object_update($data);
    
    $db = $this->app->getDbo();
    
    $db->updateObject($this->model_name, $object, 'id');
  }
  
  /***
   * delete by id
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function delete_by_id($data) {
    if (!isset($data['id'])) {
      return false;
    }
    
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
     ->delete($db->quoteName($this->model_name))
     ->where('id=' . $db->quote($data['id']));
    
    $db->setQuery($query);
     
    return $db->query();
  }
  
  /***
   * Lay thong tin theo id
   * */
  public function get_by_id ($id, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('id=' . $db->quote($id) . ' AND ' . 'system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  
  public function get_list_total ($where) {
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
      ->select('Count(*) as Total')
      ->from($db->quoteName($this->model_name));
    
   if (!empty($where)) {
     $query->where($where);
   }
   
   $db->setQuery($query);
   
    return $db->loadResult();
  }
}
?>