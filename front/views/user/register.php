<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/register.js"></script>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">
<div class="login-box" ng-controller="RegisterController" >
<form class="form-signin" role="form" ng-submit="submit()" autocomplete="off">
  <a href="/"><div class="logo"></div></a>
  <h2 class="title">
    {$app->lang('register-title-main')}
  </h2>
<div class="form-group">
<input ng-model="user.full_name" type="input" name="full_name" class="form-control" 
     placeholder="{$app->lang('register-label-full_name')}" required autofocus ng-minlength="3" ng-maxlength="255">
</div>
<div class="form-group">
<input ng-model="user.email" type="input" name="email" id="email" class="form-control" 
     placeholder="{$app->lang('register-label-email')}" required ng-minlength="3" ng-maxlength="255">
</div>
<div class="form-group">
<input ng-model="user.mobile" type="input" name="mobile" id="mobile" class="form-control" 
     placeholder="{$app->lang('register-label-mobile')}" required ng-minlength="10" ng-maxlength="12">
</div>
<div class="form-group">
<input ng-model="user.password" type="password" name="password" id="password" class="form-control" 
     placeholder="{$app->lang('register-label-password')}" required ng-minlength="6" ng-maxlength="255">
</div>
<div class="form-group">
<input ng-model="user.repassword" type="password" name="repassword" id="repassword" class="form-control" 
     placeholder="{$app->lang('register-label-repassword')}" required ng-minlength="6" ng-maxlength="255">
</div>
<div class="form-group">
<input ng-model="user.captcha" placeholder="{$app->lang('common-label-captcha')}" ng-maxlength="6" ng-minlength="6" class="captcha" type="text" id="captcha" name="captcha" />
<img src='/captcha?n=reg_captcha' alt="Protect code" />
<a class="btn btn-sm recaptcha" title="Refresh"><i class="fa fa-refresh"></i></a>
</div>
 <div>
  <span class="note">{$app->lang('common-label-password_guide_input')}</span>
</div>
<div class="alert alert-warning" ng-if="message">
<div ng-class="message_type == 1 ? 'error-message' : 'success'">
  {literal}{{ message }}{/literal}
</div>
</div>
<div class="login-btn">
<button ng-if="!registered" class="btn btn-lg btn-primary btn-block" 
  type="submit" ng-disabled="disabled()">{$app->lang('register-btn-register')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
<a ng-if="registered" class="btn btn-lg btn-primary btn-block" href="/{$app->lang('common-url-login')}">{$app->lang('register-btn-login')}</a>
</div>
</form>
</div>
</div>
<div class="col-md-4"></div>
</div>