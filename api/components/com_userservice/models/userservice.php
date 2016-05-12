<?php
defined('BASEPATH') or die;

class UserserviceModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__user_services';
    $this->service_model_name = '#__services';
    
    parent::__construct($app);
  }

  /***
   * Lay thong tin theo user_id
   * */
  public function get_by_user_id ($user_id) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('user_id=' . $db->quote($user_id));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }

/***
 * Lay danh sach services
 * */
  public function get_services_by_service_list ($service_list) {
    
    $db = $this->app->getDbo();
    
    $select = 'id, name, code, block, created_at, 
              created_by, updated_at, updated_by';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->service_model_name))
     ->where('id  IN (' . $service_list . ')');
    
   $db->setQuery($query);
    
    return $db->loadAssocList();
  }
}
?>