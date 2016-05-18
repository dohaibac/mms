<?php

if (version_compare(PHP_VERSION, '5.3.1', '<'))
{
  die('Your host needs to use PHP 5.3.1 or higher!');
} 

date_default_timezone_set('Asia/Ho_Chi_Minh');

// Global definitions
$parts = explode(DIRECTORY_SEPARATOR, __DIR__);
  
define('PATH_ROOT',  implode(DIRECTORY_SEPARATOR, $parts));

 
define('BASEPATH', __DIR__);

require_once BASEPATH . '/constants.php';
require_once BASEPATH . '/config/page.php';
require_once BASEPATH . '/includes/defined.php';
require_once BASEPATH . '/includes/framework.php';
require_once PATH_PLUGINS . '/cache/phpfastcache.php';

$app = JBase::getApplication(__APP_NAME__);

$menu = array(
  1 => array('text' => 'Item #1', 'parentID' => null),
  2 => array('text' => 'Item #2', 'parentID' => 5),
  3 => array('text' => 'Item #3', 'parentID' => 2),
  4 => array('text' => 'Item #4', 'parentID' => 2),
  5 => array('text' => 'Item #5', 'parentID' => null),
  6 => array('text' => 'Item #6', 'parentID' => 5),
  7 => array('text' => 'Item #7', 'parentID' => 3),
  8 => array('text' => 'Item #8', 'parentID' => 5),
  9 => array('text' => 'Item #9', 'parentID' => 1),
   10 => array('text' => 'Item #10', 'parentID' => 7),
);

$addedAsChildren = array();

foreach ($menu as $id => &$menuItem) { // note that we use a reference so we don't duplicate the array
  if (!empty($menuItem['parentID'])) {
    $addedAsChildren[] = $id;
    
    if (!isset($menu[$menuItem['parentID']]['children'])) {
      $menu[$menuItem['parentID']]['children'] = array($id => &$menuItem);
    } else {
      $menu[$menuItem['parentID']]['children'][$id] = &$menuItem;
    }
  }

  unset($menuItem['parentID']); // we don't need this any more
}

unset($menuItem); // unset the reference

foreach ($addedAsChildren as $itemID) {
  unset($menu[$itemID]); // remove it from root so it's only in the ['children'] subarray
}
echo '<pre>';
print_r($menu);
echo makeTree($menu);

function makeTree($menu) {
  $tree = '<ul>';
  
  foreach ($menu as $id => $menuItem) {
    $tree .= '<li>' . $menuItem['text'];
    
    if (!empty($menuItem['children'])) {
      $tree .= makeTree($menuItem['children']);
    }
    
    $tree .= '</li>';
  }
  
  return $tree . '</ul>';
}

function build_tree($data) {
    $source = array();
    $items = array();
    
    for ($i = 0; $i < $data.length; $i++) {
        $item = $data[i];
        $name = $item["username"];
        
        $label = $item["lusername"];
        $parentid = $item["lupline"];
        $id = $item["lusername"];
        $level = $item["level"];
        
        if ($items[$parentid]) {
          $item = new stdClass;
          $item->parentid = $parentid;
          $item->label = $label;
          $item->item = $item;
          $item->item = $item;
          $item->name = $name;
          $item->level = $level;
          
          if (!$items[$parentid]->items) {
            $items[$parentid]->items = array();
          }
          $len = count($items[$parentid]->items);
          $items[$parentid]->items[$len] = $item;
          $items[id] = $item;
        }
        else {
          $items[id] = new stdClass;
          $items[id]->parentid = $parentid;
          $items[id]->label = $label;
          $items[id]->item = $item;
          $items[id]->name = $name;
          $items[id]->level = $level;
         
          $source[id] = $items[id];
        }
    }
    return $source;
  }
?>