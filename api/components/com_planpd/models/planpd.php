<?php
defined('BASEPATH') or die;

class PlanpdModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__plan_pd';
    
    parent::__construct($app);
  }
  
  public function insert($data) {
    $system_code = $data['system_code'];
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true);
    
    $columns = $this->build_columns_list($data);
    
    $values = $this->build_columns_value($data, $db);
    
    // Prepare the insert query.
    $query
        ->insert($db->quoteName($this->model_name .'_' . $system_code))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));
     
    
    $db->setQuery($query);
    $db->query();
    
    return $db->insertid();
  }
  
  public function delete_by_date($system_code, $from_date, $to_date) {
    
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
     ->delete($db->quoteName($this->model_name . '_' . $system_code))
     ->where('system_code=' . $db->quote($system_code) .
     ' AND (created_at BETWEEN ' . $db->quote($from_date) .' AND ' . $db->quote($to_date) .')');
    
    $db->setQuery($query);
     
    return $db->query();
  }
  /***
   * Lay danh sach 
   * 
   * $data array
   *   - limit
   *   - page_number
   *   - where: condition
   * */
  public function get_all($data) {
    $system_code = $data['system_code'];
    
    $where = $data['where'];
    $order_by = $data['order_by'];
    
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name . '_' . $system_code));
   
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
   * Update by id
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function update_by_id($data) {
    $system_code = $data['system_code'];
    
    if (!isset($data['id'])) {
      return false;
    }
    
    $model_name = $this->model_name . '_' .$system_code;
    
    $object = $this->generate_object_update($data);
    
    $db = $this->app->getDbo();
    
    $db->updateObject($model_name, $object, 'id');
  }

  /***
   * Update by id
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function update_by_sponsor($data) {
    $system_code = $data['system_code'];
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true);
    
    $fields = array(
      $db->quoteName('updated_at') . ' = ' . $db->quote($data['updated_at']),
      $db->quoteName('updated_by') . ' = ' . $db->quote($data['updated_by']),
      $db->quoteName('status') . ' = ' . $db->quote($data['status'])
    );
    
    $conditions = array(
      $db->quoteName('sponsor') . ' = ' . $db->quote($data['sponsor']), 
      $db->quoteName('system_code') . ' = ' . $db->quote($data['system_code'])
    );
    
    $query->update($db->quoteName($this->model_name . '_' . $system_code))->set($fields)->where($conditions);
 
    $db->setQuery($query);
     
    $result = $db->execute();
  }
  
}
?>
