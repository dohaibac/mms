<?php /* Smarty version Smarty-3.1.18, created on 2016-05-12 11:20:21
         compiled from "views/system/menu.php" */ ?>
<?php /*%%SmartyHeaderCode:145234017057340485398744-38725645%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ba97cb8715d0a5858f55dcfd7ad64961cf26d5f8' => 
    array (
      0 => 'views/system/menu.php',
      1 => 1462907367,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145234017057340485398744-38725645',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'app' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_57340485431a31_57639037',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57340485431a31_57639037')) {function content_57340485431a31_57639037($_smarty_tpl) {?><div class="box">
  <div class="box-title">
      <i class="fa fa-cog"></i> <?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-label-title');?>
</div>
  <div class="box-body">
  <ul>
    <li><i class="fa fa-forumbee"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-url-setting');?>
"><?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-menu-setting');?>
</a></li>
    <hr />
    <li><i class="fa fa-user-plus"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-url-user_add');?>
"><?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-menu-user_add');?>
</a></li>
    <li><i class="fa fa-users"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-url-user_list');?>
"><?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-menu-user_list');?>
</a></li>
    <?php if ($_smarty_tpl->tpl_vars['app']->value->user->data()->group_id==1) {?>
    <li><i class="fa fa-users"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-url-user_downline_list');?>
"><?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-menu-user_downline_list');?>
</a></li>
    <?php }?>
    <hr />
    <li><i class="fa fa-user-plus"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-url-group_add');?>
"><?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-menu-group_add');?>
</a></li>
    <li><i class="fa fa-group"></i> <a href="<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-url-group_list');?>
"><?php echo $_smarty_tpl->tpl_vars['app']->value->lang('system-menu-group_list');?>
</a></li>
  </ul>
  </div>
</div><?php }} ?>
