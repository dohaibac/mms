<?php
defined('BASEPATH') or die;

class SponsorinvestModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__sponsor_invest';
    
    parent::__construct($app);
  }
  
  public function get_by_sponsor($sponsor, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('sponsor=' . $db->quote($sponsor) . ' AND ' . 'system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  
  public function get_all($system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('system_code=' . $db->quote($system_code));
    
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
  public function update_by_sponsor($data) {
    $db = $this->app->getDbo();
    $query = $db->getQuery(true);
    
    $fields = array(
      $db->quoteName('updated_at') . ' = ' . $db->quote($data['updated_at']),
      $db->quoteName('updated_by') . ' = ' . $db->quote($data['updated_by'])
    ); 
      
    $conditions = array(
      $db->quoteName('sponsor') . ' = ' . $db->quote($data['sponsor']), 
      $db->quoteName('system_code') . ' = ' . $db->quote($data['system_code'])
    );
    
    $query->update($db->quoteName($this->model_name))->set($fields)->where($conditions);
    
    $db->setQuery($query);
     
    $result = $db->execute();
  }
  
  public function delete_by_sponsor($sponsor, $system_code) {
    $db = $this->app->getDbo();
    
    $query = $db->getQuery(true)
     ->delete($db->quoteName($this->model_name))
     ->where('sponsor=' . $db->quote($sponsor) . ' AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
     
    return $db->query();
  }
}
?>