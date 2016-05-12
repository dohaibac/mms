<?php
defined('BASEPATH') or die;

class GroupHelper
{
  public function __construct($app) {
    $this->app = $app;
    
    require_once __DIR__ . '/models/group.php';
    
    $this->group_model =  new GroupModel($this->app);
  }

  
  public function add($data) {
    
    $name = $data['name'];
    $ord = $data['ord'];
    $description = $data['description'];
    $block = $data['block'];
    $system_code = $data['system_code'];
    
    $data = array(
      'name' => $name,
      'ord' => $ord,
      'description' =>$description,
      'block' =>$block,
      'system_code' => $system_code,
      'created_by' => $this->app->user->data()->id,
      'created_at' => date('Y-m-d h:i:s')
    );
     
    return $this->group_model->post($data);
  }
 }
?>