<?php
// enable modules depending on page name

$mod_conf = array(
	'home' => array('mod_menu', 'mod_slider', 'mod_featured', 'mod_user'),	
	'gallery' => array('mod_menu', 'mod_featured_subpage', 'mod_user'),
	'gallery-detail' => array('mod_menu', 'mod_featured_subpage', 'mod_user'),
	'news' => array('mod_menu', 'mod_user'),
	'news-detail' => array('mod_menu', 'mod_user'),
	'guide' => array('mod_menu', 'mod_user'),
	'guide-detail' => array('mod_menu', 'mod_user')
);
?>