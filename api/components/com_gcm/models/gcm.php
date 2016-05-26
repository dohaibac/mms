<?php
defined('BASEPATH') or die;

class GcmModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__gcm_users';
    
    parent::__construct($app);
  }
  
  /***
   * Lay thong tin group theo name
   * */
  public function get_user_by_email ($email, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('email=' . $db->quote($email) . ' AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }

  /***
   * Lay thong gcm theo hardware id
   * */
  public function get_by_hardware_id ($hardware_id) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('hardware_id=' . $db->quote($hardware_id));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }

  /***
   * Lay danh sach user group
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
   * Update by hardware_id
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function update_by_hardware_id($data) {
    if (!isset($data['hardware_id'])) {
      return false;
    }
    
    $object = $this->generate_object_update($data);
    
    $db = $this->app->getDbo();
    
    $db->updateObject($this->model_name, $object, 'hardware_id');
  }
  
    /***
   * delete by hardware_id
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function delete_by_hardware_id($hardware_id) {
    if (empty($hardware_id)) {
      return false;
    }
    
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
     ->delete($db->quoteName($this->model_name))
     ->where('hardware_id=' . $db->quote($hardware_id));
    
    $db->setQuery($query);
     
    return $db->query();
  }
  
  /***
   * Lay danh sach user group
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