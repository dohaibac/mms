<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/forgot_password.js"></script>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">
<div class="login-box" ng-controller="ForgotPasswordController">
<a href="/"><div class="logo"></div></a>
<form class="form-signin" role="form" ng-submit="submit()" autocomplete="off">
<div class="form-group">
<label for="email" class="control-label">{$app->lang('forgot_password-label-email')}:</label>
<input ng-model="user.email"  type="email" id="email" name="email" class="form-control" 
     placeholder="Email address"  ng-maxlength="255" required autofocus accesskey="e" autocomplete="off">
</div>
<div class="form-group">
<label for="captcha" class="control-label">{$app->lang('common-label-captcha')}:</label>
<div>
<input ng-model="user.captcha" class="captcha" ng-maxlength="6" type="text" id="captcha" name="captcha" placeholder="" />
<img src='/captcha' alt="Protect code" />
<a class="btn btn-sm recaptcha" title="Refresh"><i class="fa fa-refresh"></i></a>
</div>
</div>

<div ng-class="message_type == 1 ? 'error-message' : 'success'" ng-if="message">
    {literal}{{ message }}{/literal}
</div>
<div class="login-btn">
<button class="btn btn-lg btn-primary btn-block" type="submit" 
  ng-disabled="disabled()">{$app->lang('forgot_password-btn-send')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
</div>
<div class="login-btn">
  <a href="/{$app->lang('forgot_password-url-login')}">{$app->lang('forgot_password-menu-login')}</a>
</div>
</form>
</div>
</div>
<div class="col-md-4"></div>
</div>