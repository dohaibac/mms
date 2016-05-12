<?php
defined('BASEPATH') or die;

class UserModel extends JModelBase {
  
  public function __construct($app) {
    
    $this->model_name = '#__users';
    
    parent::__construct($app);
  }
  
  /***
   * Update user by email
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function update_by_email($data) {
    if (!isset($data['email'])) {
      return false;
    }
    
    $object = $this->generate_object_update($data);
    
    $db = $this->app->getDbo();
    
    $db->updateObject($this->model_name, $object, 'email');
  }
  
  
  /***
   * delete user by email
   * 
   * $data array
   * 
   * @return mix
   * 
   * */
  public function delete_by_email($data) {
    if (!isset($data['email'])) {
      return false;
    }
    
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
     ->delete($db->quoteName($this->model_name))
     ->where('email=' . $db->quote($data['email']));
    
    $db->setQuery($query);
     
    return $db->query();
  }
  
  /***
   * Lay thong tin user theo email
   * */
  public function get_user_by_email ($email) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('email=' . $db->quote($email));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
    /***
   * Lay thong tin user theo email
   * */
  public function get_user_by_email_system_code ($email, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('(email=' . $db->quote($email) . ' or user_name=' . $db->quote($email) .') AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
 
    /***
   * Lay thong tin user theo username
   * */
  public function get_by_user_name ($user_name, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('user_name=' . $db->quote($user_name) .' AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
 /***
   * Lay thong tin user theo email
   * */
  public function get_by_email ($email, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('email=' . $db->quote($email) .' AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  /***
   * Lay thong tin user theo email and khac id
   * */
  public function get_user_by_email_and_dif_id ($email, $id) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('email=' . $db->quote($email) . ' AND id <> ' . $db->quote($id));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  /***
   * Lay thong tin user theo email
   * */
  public function get_by_group_id ($group_id, $system_code) {
    $db = $this->app->getDbo();
    
    $select = 'id, user_name, display_name, email, mobile, block, group_id, created_at, created_by';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('group_id=' . $db->quote($group_id) .' AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadAssocList();
  }
  
  /***
   * Lay danh sach user
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
    
    $select = 'id, user_name, email, block, send_mail, created_at, 
              created_by, active, group_id, display_name, mobile, avatar, 
              user_type, addr, email_confirmed, updated_at, updated_by, sponsor_owner, block, system_code';
    
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