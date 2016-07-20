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
  
  public function get_list_f1($list, $sponsor) {
    $ret = array();
    $username = strtolower($sponsor['username']);
    
    foreach($list as $item) {
      $upline = strtolower($item['upline']);
      
      if ($username == $upline) {
        $ret []= $item;
      }
    }
    
    return $ret;
  }
  
  public function get_list_fork($list, $sponsor) {
    // lay danh sach F1
    // kiem tra F1 da co F1 chua?
    
    $list_f1 = $this->get_list_f1($list, $sponsor);
    
    $list_fork = array();
    
    foreach($list_f1 as $item) {
      $item_list_f1 = $this->get_list_f1($list, $item);
      
      if (count($item_list_f1) > 0) {
        $list_fork []= $item;
      }
    }
    
    return $list_fork;
  }
  /***
   * Lay danh sach cac ma khong du 5 F1
   * */
  public function get_list_sponsor_has_less_than_5_f1($sponsors) {
    $ret = array();
    
    foreach($sponsors as $item) {
      $d = $this->get_list_f1($sponsors, $item);
      
      if (count($d) < 5 && count($d) > 0) {
        $path_length = explode('>', $item['path']);
        $level = $item['level'];
        $f1 = array(
          'username'=>$item['username'], 
          'path_length'=> count($path_length), 
          'level'=> $level,
          'n_f1'=> count($d)
         );
        array_push($ret, $f1);
      }
    }
    
    return $this->sort_sponsors($ret);
  }
  
  /***
   * Lay danh sach cac ma chua phat trien du 3 nhanh
   * 
   * */
  public function get_list_less_than_3_fork($sponsors) {
    $ret = array();
    
    foreach($sponsors as $item) {
      $d = $this->get_list_fork($sponsors, $item);
      
      if (count($d) < 3 && count($d) > 0) {
        $path_length = explode('>', $item['path']);
        $level = $item['level'];
        
        $fork = array(
            'username'=>$item['username'], 
            'path_length'=> count($path_length), 
            'level'=> $level,
            'n_fork'=> count($d)
        );
        array_push($ret, $fork);
      }
    }
    
    return $this->sort_sponsors($ret);
  }
  
  function sort_sponsors($data) {
    $level = array();
    $path_leng = array();
    
    foreach ($data as $key => $row) {
      $path_leng[$key] = $row['path_length'];
      $level[$key]  = $row['level'];
    }
    
    array_multisort($path_leng, SORT_ASC, $level, SORT_ASC, $data);
    
    return $data;
  }
}

?>
