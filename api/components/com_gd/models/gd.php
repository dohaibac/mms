<?php
defined('BASEPATH') or die;

class GdModel extends JModelBase {
  
  public function __construct($app) {
    $this->model_name = '#__gds';
    
    parent::__construct($app);
  }

  /***
   * Lay thong tin code
   * */
  public function get_by_code ($code, $system_code) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('code=' . $db->quote($code) . ' AND system_code=' . $db->quote($system_code));
    
    $db->setQuery($query);
    
    return $db->loadObject();
  }
  /***
   * Lay thong tin bank theo name va khac id
   * */
  public function get_gd_by_code_and_dif_id ($code, $id) {
    $db = $this->app->getDbo();
    
    $select = '*';
    
    $query = $db->getQuery(true)
     ->select($select)
     ->from($db->quoteName($this->model_name))
     ->where('code=' . $db->quote($code) . ' AND id <> ' . $db->quote($id));
    
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
  
   /***
   * get total in each status of GD by a complex query
   * 
   * */
  public function get_status() {    
    $db = $this->app->getDbo();
    
    #$select = "status , count( id ) as stotal";
    
    #$query = $db->getQuery(true)
    #  ->select($select)
    #  ->from($db->quoteName($this->model_name));
      
    #$query->order("status");
    #$query->group("status");
    
    $query = "SELECT B.name, Count( A.ID ) AS stotal FROM m_gds AS A RIGHT JOIN ( SELECT * FROM m_status WHERE TYPE = 'gd') AS B ON A.status = B.value GROUP BY A.status ORDER BY B.value";

    $db->setQuery($query);
    
    return $db->loadAssocList();
  }
}
?>
