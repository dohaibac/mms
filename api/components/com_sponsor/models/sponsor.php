<?php
defined('BASEPATH') or die;

class SponsorModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__sponsor';
    
    parent::__construct($app);
  }

  /***
   * Lay thong tin bank theo name
   * */
  public function get_sponsor_by_name_account_number ($name, $account_number, $system_code) {
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
  public function get_sponsor_by_name_account_number_and_dif_id ($name, $account_number, $id) {
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
   /***
   * Lay thong tin sponsor dau tien
   * */
  public function get_top_one ($system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  /***
   * Lay thong tin sponsor invest
   * */
  public function get_sponsor_invest ($system_code) {
    $db = $this->app->getDbo();
    
    $select = "s.*, invt.updated_at as updated_at_invest";
    
    $query = $db->getQuery(true)
      ->select($select)
      ->from($db->quoteName($this->model_name, 's'))
      ->join('INNER', $db->quoteName('#__sponsor_invest', 'invt') . ' ON (' . $db->quoteName('s.username') . ' = ' . $db->quoteName('invt.sponsor') . ')')
      ->where('s.system_code=' . $db->quote($system_code))
      ->order('invt.updated_at ASC');
     
    $db->setQuery($query);
   
    return $db->loadAssocList();
  }
   /***
   * get by username
   * */
  public function get_by_username ($username) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('username=' . $db->quote($username));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
   /***
   * get by downline f1
   * */
  public function get_by_downline_f1 ($upline) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('upline=' . $db->quote($upline))
     ->order('level, id');;
    
    $db->setQuery($query);
    
    return $db->loadAssocList();
  }
  
  public function get_list_username_by_path($sponsor_owner){
    $db = $this->app->getDbo();
    
    $sponsor = $this->get_by_username($sponsor_owner);
    $sponsor_path = $sponsor->path;
    $sponsor_where = 'path LIKE \''. $sponsor_path .'%\'';
    $sponsor_order_by ='level, id';
  
    $sponsor_data = array(
      'where'=>$sponsor_where,
      'order_by'=>$sponsor_order_by,
      'start_index'=>1,
      'limit' => 50000000
    );
   
    $sponsor_result = $this->get_list($sponsor_data);

    $sponsor_username = "";

    foreach($sponsor_result as $spr) {
      $sponsor_username .= $db->quote($spr["username"]) . ",";
    }
    
    return substr($sponsor_username,0,-1);
  }
  
   /***
   * get by username
   * */
  public function get_upline ($username) {
    $db = $this->app->getDbo();
    
    $select = 'a.*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name). ' as a')
     ->join('LEFT', $db->quoteName($this->model_name) . ' as b ON a.username = b.upline')
     ->where('b.username=' . $db->quote($username));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  public function update_has_fork($username, $has_fork) {
    
    $object = $this->generate_object_update(array('username'=>$username, 'has_fork'=>$has_fork));
    
    $db = $this->app->getDbo();
    
    $db->updateObject($this->model_name, $object, 'username');
  }
  
   /***
   * delete by id
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function delete_by_sponsor($sponsor) {
    
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
     ->delete($db->quoteName($this->model_name))
     ->where('username=' . $db->quote($sponsor));
    
    $db->setQuery($query);
    
    return $db->query();
  }
  
}
?>
