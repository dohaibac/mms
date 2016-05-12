{if $data['type'] == 0}
<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/user_active.js"></script>
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4">
<div class="login-box" ng-controller="UserActiveController" ng-init="user.email='{{$email}}'" >
<a href="/" ng-init="init()"><div class="logo"></div></a>
<div class="alert alert-warning form-group get-password-alert" ng-if="message">
<div ng-class="message_type == 1 ? 'error-message' : 'success'">
  {literal}{{ message }}{/literal}
</div>
</div>
<div class="form-group" ng-if="message_type == 0">
  <a class="btn btn-lg btn-primary btn-block" href="/{$app->lang('common-url-login')}">{$app->lang('register-btn-login')}</a>
</div>
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
</div>
<div class="col-md-4"></div>
</div>
{/if}
