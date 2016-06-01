<?php
defined('BASEPATH') or die;

class SponsorHelper
{
  public function __construct($app) {
    require_once __DIR__ . '/models/sponsor.php';
    $this->app = $app;
    $this->sponsor_model =  new SponsorModel($app);
  }
  
  public function get_list() {
    $db = $this->app->getDbo();
    
    // get sponsor
    $sponsor = $this->sponsor_model->get_by_username(array('username' => $this->app->user->data()->sponsor_owner));
   
    $data = $sponsor->body;
    
    $data = $data->data;
    $path = $data->path;
    
    $where = 'path LIKE \''. $path .'%\'';
    
    $current_page = 1;
    $order_by ='level, id';
    
    $data = array(
      'where'=>$where,
      'order_by'=>$order_by,
      'page_number'=>$current_page,
      'limit' => 50000000
    );
     
    $result = $this->sponsor_model->get_list($data);
    
    return $result->body;
  }
  
  /***
   * Lay array username sponsor
   * */
  public function get_array($db, $sponsors) {
    $ret = array();
    
    foreach($sponsors as $sponsor) {
      $ret []= $db->quote($sponsor->username);
    }
    
    return $ret;
  }

  public function build_tree($data) {
    $source = array();
    $items = array();
    
    foreach($data as $item) {
      $name = $item["username"];
      
      $label = $item["lusername"];
      $parentid = $item["lupline"];
      $id = $item["lusername"];
      $level = $item["level"];
      $has_fork = $item["has_fork"];
      
      if (isset($items[$parentid])) {
        $obj = new stdClass;
        
        $obj->parentid = $parentid;
        $obj->label = $label;
        $obj->item = $item;
        $obj->name = $name;
        $obj->level = $level;
        $obj->has_fork = $has_fork;
        
        if (!isset($items[$parentid]->items)) {
          $items[$parentid]->items = array();
        }
        
        $n = count($items[$parentid]->items);
        $items[$parentid]->items[$n] = $obj;
        
        $items[$id] = $obj;
      }
      else {
        $obj = new stdClass;
        $obj->parentid = $parentid;
        $obj->label = $label;
        $obj->item = $item;
        $obj->name = $name;
        $obj->level = $level;
        $obj->has_fork = $has_fork;
        
        $items[$id] = $obj;
        
        $source[$id] = $items[$id];
        
      }
   }
  
    return $source;
  }
}

?>