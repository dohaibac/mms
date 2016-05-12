<?php /* Smarty version Smarty-3.1.18, created on 2016-05-12 11:20:21
         compiled from "views/system/index.php" */ ?>
<?php /*%%SmartyHeaderCode:863393464573404852f74f5-76991006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8ab1c941bdefe3e388eadf3149e190d14fb322c' => 
    array (
      0 => 'views/system/index.php',
      1 => 1462228280,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '863393464573404852f74f5-76991006',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'app' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_573404853605c7_53680300',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_573404853605c7_53680300')) {function content_573404853605c7_53680300($_smarty_tpl) {?><script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/sponsor.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/group.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/user.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/setting.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/controllers/setting.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/controllers/group.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/controllers/user/user.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/router/system.js"></script>

<div ng-view></div>
<?php }} ?>
