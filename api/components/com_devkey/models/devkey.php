<?php
defined('BASEPATH') or die;

class DevkeyModel extends JModelBase {
  
  public function __construct($app) {
    
    $this->model_name = '#__dev_keys';
    
    parent::__construct($app);
  }

  /***
   * Lay thong tin theo api_key
   * */
  public function get_by_api_key($api_key) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('api_key=' . $db->quote($api_key));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  /***
   * Lay thong tin theo api_key va khac id
   * */
  public function get_by_api_key_and_dif_id ($api_key, $id) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('api_key=' . $db->quote($api_key) . ' AND id <> ' . $db->quote($id));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }

  /***
   * Lay danh sach devkeys
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
    
    $select = 'id, api_key, secret, app_name, block, allow_methods, api_code, allow_ips, description, created_at, 
              created_by, updated_at, updated_by';
    
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
}
?>