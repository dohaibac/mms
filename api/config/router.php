<?php  

defined('BASEPATH') or die;
/***
 * Router he thong
 * 
 * */

$routerMap = array(
  'status'=> array('controller'=>'cpanel', 'action'=>'index'),
/*======================================
 * Config for user
 * 
 * =====================================*/
  'user'=> array('controller'=>'user', 'action'=>'index'),
  'user/get_by_username'=> array('controller'=>'user', 'action'=>'get_by_username'),
  'user/get_by_email'=> array('controller'=>'user', 'action'=>'get_by_email'),
  'user/get_by_group_id'=> array('controller'=>'user', 'action'=>'get_by_group_id'),
  'user/list'=> array('controller'=>'user', 'action'=>'get_list'),
  
/*======================================
 * Config for usergroup
 * 
 * =====================================*/
  'group'=> array('controller'=>'group', 'action'=>'index'),
  'group/list'=> array('controller'=>'group', 'action'=>'get_list'),
  

/*======================================
 * Config for bank
 * 
 * =====================================*/
  'bank'=> array('controller'=>'bank', 'action'=>'index'),
  'bank/list'=> array('controller'=>'bank', 'action'=>'get_list'),

/*======================================
 * Config for Sponsor
  * 
  * Insert, update, delete theo menu_id
 * 
 * =====================================*/
  'sponsor'=> array('controller'=>'sponsor', 'action'=>'index'),
  'sponsor/list'=> array('controller'=>'sponsor', 'action'=>'get_list'),
  'sponsor/top_one'=> array('controller'=>'sponsor', 'action'=>'get_top_one'),
  'sponsor/get_by_username'=> array('controller'=>'sponsor', 'action'=>'get_by_username'),
  'sponsor/get_downline_f1'=> array('controller'=>'sponsor', 'action'=>'get_downline_f1'),
  'sponsor/get_upline'=> array('controller'=>'sponsor', 'action'=>'get_upline'),
  'sponsor/bank'=> array('controller'=>'sponsorbank', 'action'=>'index'),
  'sponsor/update_has_fork'=> array('controller'=>'sponsor', 'action'=>'update_has_fork'),


/*======================================
 * Config for pd
 * 
 * =====================================*/
  'pd'=> array('controller'=>'pd', 'action'=>'index'),
  'pd/list'=> array('controller'=>'pd', 'action'=>'get_list'),


/*======================================
 * Config for gd
 * 
 * =====================================*/
  'gd'=> array('controller'=>'gd', 'action'=>'index'),
  'gd/list'=> array('controller'=>'gd', 'action'=>'get_list'),

/*======================================
 * Config for bank
 * 
 * =====================================*/
  'setting'=> array('controller'=>'setting', 'action'=>'index'),
  'setting/list'=> array('controller'=>'setting', 'action'=>'get_list'),
  
 /*======================================
 * Config for menu
  * 
  * Insert, update, delete theo menu_id
 * 
 * =====================================*/
  'menu'=> array('controller'=>'menu', 'action'=>'index'),
  'menu/list'=> array('controller'=>'menu', 'action'=>'get_list'),
  
/*======================================
 * Ung vien tiem nang
 * 
 * =====================================*/
  'candidate'=> array('controller'=>'candidate', 'action'=>'index'),
  'candidate/list'=> array('controller'=>'candidate', 'action'=>'get_list'),
  
 /*======================================
 * Config for usergroup
 * 
 * =====================================*/
  'systemcode'=> array('controller'=>'systemcode', 'action'=>'index'),
  'systemcode/list'=> array('controller'=>'systemcode', 'action'=>'get_list'),
  'systemcode/get_latest'=> array('controller'=>'systemcode', 'action'=>'get_latest'),
  
  
 /*======================================
  * Config for gcm
  * 
  * Insert, update, delete theo menu_id
  * 
  * =====================================*/
  'gcm'=> array('controller'=>'gcm', 'action'=>'index'),
  'gcm/list'=> array('controller'=>'gcm', 'action'=>'get_list'),
  'gcm/send'=> array('controller'=>'gcm', 'action'=>'send_notification'),
);

/* End of file routes.php */
/* Location: ./config/routes.php */