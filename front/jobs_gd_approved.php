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

// Can cu vao so ngay cho GD hoan thanh de tinh ra GD da xong. insert vao table moi

$ctrl = 'jobs';
$task = 'set_gd_to_approved';

$controller = $app->getController($ctrl);

$data = $controller->execute($task);


?>