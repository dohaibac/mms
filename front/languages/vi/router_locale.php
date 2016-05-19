<?php 
/***
 * File nay se dinh nghia router cua website; hay con goi la rewrite url,
 * moi 1 dinh nghia se cho biet url nao tuong ung voi page nao
 * 
 * Viec dinh nghia page thi xem trong config/page.php
 * 
 * 
 * 
 * */
$routerConf = array();

$routerConf['/^$/'] = array('page'=>'cpanel');
$routerConf['/^status$/'] = array('page'=>'cpanel', 'controller'=>'cpanel', 'action'=>'index');
$routerConf['/^login$/'] = array('page'=>'login');
$routerConf['/^logout$/'] = array('page'=>'logout', 'controller'=>'user', 'action'=>'logout');
$routerConf['/^register$/'] = array('page'=>'register');
$routerConf['/^forgot-password/'] = array('page'=>'forgot_password');
$routerConf['/^profile$/'] = array('page'=>'profile');
$routerConf['/^services$/'] = array('page'=>'services');
$routerConf['/^user$/'] = array('page'=>'user');
$routerConf['/^help-guide$/'] = array('page'=>'helpguide');
$routerConf['/^captcha$/'] = array('page'=>'cpanel', 'controller'=>'captcha', 'action'=>'index');
$routerConf['/^get-password$/'] = array('page'=>'getpassword');
$routerConf['/^user-active$/'] = array('page'=>'useractive');
$routerConf['/^menu$/'] = array('page'=>'menu');
$routerConf['/^menu/edit/'] = array('page'=>'menu');
$routerConf['/^usersys$/'] = array('page'=>'usersystem');
$routerConf['/^system$/'] = array('page'=>'system');
$routerConf['/^pd$/'] = array('page'=>'pd');
$routerConf['/^gd$/'] = array('page'=>'gd');
$routerConf['/^sponsor$/'] = array('page'=>'sponsor');
$routerConf['/^other$/'] = array('page'=>'other');
$routerConf['/^dashboard$/'] = array('page'=>'dashboard');
$routerConf['/^report$/'] = array('page'=>'report');
$routerConf['/^gcm$/'] = array('page'=>'gcm');
$routerConf['/^gcm\/register$/'] = array('page'=>'gcm', 'controller'=>'gcm', 'action'=>'register');
$routerConf['/^gcm\/send$/'] = array('page'=>'gcm', 'controller'=>'gcm', 'action'=>'send_notification');
$routerConf['/^gcm\/logout/'] = array('page'=>'gcm', 'controller'=>'gcm', 'action'=>'logout');
$routerConf['/^gcm\/update/'] = array('page'=>'gcm', 'controller'=>'gcm', 'action'=>'update');

// api cho phep site khac lay thong tin user
$routerConf['/^api\/get-user-session$/'] = array('page'=>'cpanel', 'controller'=>'user', 'action'=>'get_user_session');

?>