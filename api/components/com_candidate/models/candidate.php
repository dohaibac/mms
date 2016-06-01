<?php
defined('BASEPATH') or die;

class CandidateModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__candidates';
    
    parent::__construct($app);
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
    
    $select = 'ca.id, email , display_name , mobile , addr , created_at , name as province';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name, 'ca'))
     ->join('LEFT', $db->quoteName('#__provinces', 'pr') . ' ON (' . $db->quoteName('ca.province_id') . ' = ' . $db->quoteName('pr.id') . ')');
   
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
