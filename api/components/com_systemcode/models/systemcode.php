<?php
defined('BASEPATH') or die;

class SystemcodeModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__system_code';
    
    parent::__construct($app);
  }
  
  /***
   * Lay thong tin user theo email
   * */
  public function get_by_code ($code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('code=' . $db->quote($code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  /***
   * Get latest systemcode
   * 
   * */
  public function get_latest () {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->order('id desc');
    
    $db->setQuery($query,0,1);
    
    return $db->loadObject();
  }
  
}
?>