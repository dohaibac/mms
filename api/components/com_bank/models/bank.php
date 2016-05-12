<?php
defined('BASEPATH') or die;

class BankModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__banks';
    
    parent::__construct($app);
  }

  /***
   * Lay thong tin bank theo name
   * */
  public function get_bank_by_name_account_number ($name, $account_number, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('name=' . $db->quote($name) . ' AND system_code=' . $db->quote($system_code) .
            ' AND account_number=' . $db->quote($account_number));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  /***
   * Lay thong tin bank theo name va khac id
   * */
  public function get_bank_by_name_account_number_and_dif_id ($name, $account_number, $id) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('name=' . $db->quote($name) . ' AND id <> ' . $db->quote($id) .
            ' AND account_number=' . $db->quote($account_number));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }

  /***
   * Lay danh sach user bank
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
}
?>