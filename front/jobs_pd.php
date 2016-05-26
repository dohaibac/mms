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

// Job tinh toan cac lenh PD trong ngay
// Can cu vao thoi gian So ngay cho PD : num_days_pd_pending

$ctrl = 'jobs';
$task = 'get_pd_in_day';

$controller = $app->getController($ctrl);

$data = $controller->execute($task);


?>