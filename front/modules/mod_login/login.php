<?php

$from = $this->uri->getVar('from');

if (empty($from)) {
  $from = $this->lang('common-url-dashboard');
}

$is_guest = $this->user->isGuest();

$this->setVars(array('from'=>$from, 'is_guest'=>$is_guest,'user'=>$this->user->data()));

$this->loadView('user/login');

?>