<?php

defined('BASEPATH') or die;

$message = $this->getMessageQueue();

if (!empty($message)) {
  $type    = $message[0]['type'];
  $message = $message[0]['message'];
}
else {
  $type = '';
  $message = '';
}

$this->setVars('type', $type);
$this->setVars('message', $message);

$this->loadView('message/index');

?>
