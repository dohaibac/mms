<?php /* Smarty version Smarty-3.1.18, created on 2016-05-12 10:33:33
         compiled from "views/user/login.php" */ ?>
<?php /*%%SmartyHeaderCode:18668963945733f98d473817-44323926%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7acccdcb0fe3e81e9beb99193b67522849afec6c' => 
    array (
      0 => 'views/user/login.php',
      1 => 1462466620,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18668963945733f98d473817-44323926',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'is_guest' => 0,
    'user' => 0,
    'from' => 0,
    'app' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.18',
  'unifunc' => 'content_5733f98d53aed8_31094262',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5733f98d53aed8_31094262')) {function content_5733f98d53aed8_31094262($_smarty_tpl) {?><div class="row">
  <div class="col-md-4">
    
  </div>
<div class="col-md-4">
<script type="text/javascript">
app.controller('LoginController', function($scope, $http) {
  $scope.user = {};
  $scope.user.email = '';
  $scope.user.password = '';
  $scope.processing = false;
  
  $scope.disabled = function() {
    if (!$scope.user.email || !$scope.user.password || $scope.processing) {
      return true;
    }
    return $scope.user.email.length > 0 && $scope.user.password.length > 0 ? false : true;
  };
  
  $scope.submit = function() {
    $scope.message = '';
    $scope.processing = true;
    
    var url = generate_url ('user', 'login');
    
    $http({
     method  : 'POST',
     url     : url,
     data    : $scope.user, 
     headers : { 'Content-Type': 'application/x-www-form-urlencoded' }
    })
    .success(function(data) {
      $scope.processing = false;
      
      if (data.type == 0) {
        if (data.from && data.from != '') {
          window.location.href = data.from;
          return;
        }
      }
      $scope.message = data.message;
   });
  };
  
});
</script>
<div class="login-box" ng-controller="LoginController">
<div class="logo"></div>
<form class="form-signin" role="form" ng-submit="submit()">
<?php if (!$_smarty_tpl->tpl_vars['is_guest']->value) {?>
<div class="readonly-email">
  <?php if ($_smarty_tpl->tpl_vars['user']->value->display_name!='') {?>
<span><b><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['user']->value->display_name;?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
</b></span>
<?php }?>
</div>
<div class="readonly-email">
<span ng-model="user.email" 
    ng-init="user.email='<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
'" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
<?php $_tmp3=ob_get_clean();?><?php echo $_tmp3;?>
"
     placeholder="Email address" required autofocus accesskey="e" disabled="disabled"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
<?php $_tmp4=ob_get_clean();?><?php echo $_tmp4;?>
</span>
</div>
<?php } else { ?>
<label for="email">Email / User name</label>
<input ng-model="user.email" type="text" id="email" name="email" class="form-control" 
      required autofocus accesskey="e" >
<?php }?>
<label for="password">Password</label>
<input ng-model="user.password"  type="password" id="password" name="password" 
  class="form-control">
<label for="system_code">System Code</label>
<input ng-model="user.system_code"  type="text" id="system_code" name="system_code" class="form-control" >

<input type="hidden" value="<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['from']->value;?>
<?php $_tmp5=ob_get_clean();?><?php echo $_tmp5;?>
" ng-init="user.from='<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['from']->value;?>
<?php $_tmp6=ob_get_clean();?><?php echo $_tmp6;?>
'" />

<div class="error-message" ng-if="message">
    {{ message }}
</div>
<div class="login-btn">
<button class="btn btn-sm btn-primary" 
  type="submit" ng-disabled="disabled()"><?php echo $_smarty_tpl->tpl_vars['app']->value->lang('common-btn-login');?>
 <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
</div>
<div class="login-link">
  <ul>
    <?php if (!$_smarty_tpl->tpl_vars['is_guest']->value) {?>
    <li><i class="fa fa-user"></i><a href="/<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('common-url-logout');?>
"> <?php echo $_smarty_tpl->tpl_vars['app']->value->lang('login-menu-try_a_dif_account');?>
</a></li>
    <?php }?>
    <li><i class="fa fa-minus-square"></i><a href="/<?php echo $_smarty_tpl->tpl_vars['app']->value->lang('login-url-forgot_password');?>
"> <?php echo $_smarty_tpl->tpl_vars['app']->value->lang('login-menu-forgot_password');?>
</a></li>
  </ul>
</div>
</form>
</div>
</div>
<div class="col-md-4"></div>
</div><?php }} ?>
