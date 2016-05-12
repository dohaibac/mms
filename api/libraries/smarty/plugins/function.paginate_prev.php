<?php
 function smarty_function_paginate_prev($params, &$smarty) { $_id = 'default'; $_attrs = array(); if (!class_exists('SmartyPaginate')) { $smarty->trigger_error("paginate_prev: missing SmartyPaginate class"); return; } if (!isset($_SESSION['SmartyPaginate'])) { $smarty->trigger_error("paginate_prev: SmartyPaginate is not initialized, use connect() first"); return; } foreach($params as $_key => $_val) { switch($_key) { case 'id': if (!SmartyPaginate::isConnected($_val)) { $smarty->trigger_error("paginate_prev: unknown id '$_val'"); return; } $_id = $_val; break; default: $_attrs[] = $_key . '="' . $_val . '"'; break; } } if (SmartyPaginate::getTotal($_id) === false) { $smarty->trigger_error("paginate_prev: total was not set"); return; } $_url = SmartyPaginate::getURL($_id); $_attrs = !empty($_attrs) ? ' ' . implode(' ', $_attrs) : ''; if(($_item = SmartyPaginate::_getPrevPageItem($_id)) !== false) { $_show = true; $_text = isset($params['text']) ? $params['text'] : SmartyPaginate::getPrevText($_id); $_url .= (strpos($_url, '?') === false) ? '?' : '&'; $_url .= SmartyPaginate::getUrlVar($_id) . '=' . $_item; } else { $_show = false; } return $_show ? '<a href="' . str_replace('&','&amp;', $_url) . '"' . $_attrs . '>' . $_text . '</a>' : ''; } ?>