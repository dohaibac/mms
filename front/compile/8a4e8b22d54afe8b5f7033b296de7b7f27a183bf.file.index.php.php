<?php /* Smarty version Smarty-3.1.18, created on 2016-05-12 11:16:01
         compiled from "views/pd/index.php" */ ?>
<?php /*%%SmartyHeaderCode:8781174235734038199a695-29219846%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8a4e8b22d54afe8b5f7033b296de7b7f27a183bf' => 
    array (
      0 => 'views/pd/index.php',
      1 => 1462725192,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8781174235734038199a695-29219846',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'app' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_57340381a0dfc4_46313263',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57340381a0dfc4_46313263')) {function content_57340381a0dfc4_46313263($_smarty_tpl) {?><script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/bank.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/setting.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/sponsor.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/service/pd.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/controllers/pd.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['app']->value->appConf->theme_default;?>
/js/router/pd.js"></script>

<div ng-view></div>
<?php }} ?>
