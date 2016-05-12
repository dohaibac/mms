<?php
defined('BASEPATH') or die;

class SponsorbankModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__sponsor_bank';
    
    parent::__construct($app);
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
}
?>