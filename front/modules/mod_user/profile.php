<?php

$user = $this->user->data();
$this->setVars(array('user'=>$user));
$this->loadView('user/profile');

?>