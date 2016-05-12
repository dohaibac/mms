<?php

$ctrl = 'gcm';
$task = 'get_list';

$controller = $this->getController($ctrl);

$data = $controller->execute($task);

$this->setVars(array('data'=>$data));

$this->loadView('gcm/index');

?>