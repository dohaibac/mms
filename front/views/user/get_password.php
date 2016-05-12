{if $data['type'] == 0}
<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/get_password.js"></script>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">
<div class="login-box" ng-controller="GetPasswordController" ng-init="user.email='{{$email}}'" >
<form class="form-signin" role="form" ng-submit="submit()" autocomplete="off">
<a href="/"><div class="logo"></div></a>
<div class="form-group">
<label for="password_new" class="control-label">{$app->lang('get_password-label-password_new')}:</label>
<input ng-model="user.password_new"  type="password" name="password_new" class="form-control" 
     placeholder="" required autofocus accesskey="e" autocomplete="off" ng-minlength="6">
</div>
<div class="form-group">
<label for="password_renew" class="control-label">{$app->lang('get_password-label-password_renew')}:</label>
<input ng-model="user.password_renew"  type="password" name="password_renew" class="form-control" 
     placeholder="" required autocomplete="off" ng-minlength="6">
</div>
<div class="form-group">
<label for="captcha" class="control-label">{$app->lang('common-label-captcha')}:</label>
<div>
<input ng-model="user.captcha" ng-maxlength="6" ng-minlength="6" class="captcha" type="text" id="captcha" name="captcha" placeholder="" />
<img src='/captcha' alt="Protect code" />
<a class="btn btn-sm recaptcha" title="Refresh"><i class="fa fa-refresh"></i></a>
</div>
</div>
 <div>
  <span class="note">{$app->lang('common-label-password_guide_input')}</span>
</div>
<div ng-class="message_type == 1 ? 'error-message' : 'success'" ng-if="message">
  {literal}{{ message }}{/literal}
</div>
<div class="login-btn">
<button class="btn btn-lg btn-primary btn-block" 
  type="submit" ng-disabled="disabled()">{$app->lang('get_password-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
</div>
</form>
</div>
</div>
<div class="col-md-4"></div>
</div>
{else}
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">
  <div class="alert alert-warning form-group get-password-alert">
  {{$data['message']}}
  </div>
  <a href="/{$app->lang('login-url-forgot_password')}"> {$app->lang('login-menu-forgot_password')}</a>
</div>
<div class="col-md-4"></div>
</div>
{/if}
