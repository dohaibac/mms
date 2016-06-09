<script type="text/javascript" src="/themes/default/js/controllers/user/login.js"></script>
<div class="cont" ng-controller="LoginController">
  <input type="hidden" value="{{$from}}" ng-init="user.from='{{$from}}' && init()" />
  <div class="demo">
    <form class="form-signin" role="form" ng-submit="submit()">
    <div class="login" ng-show="!show_form_code">
      <div class="login__form">
        <div class="login__row">
          <svg class="login__icon email svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 a10,8 0 0,1 20,0z M10,0 a4,4 0 0,1 0,8 a4,4 0 0,1 0,-8" />
          </svg>
          <input type="text" ng-model="user.email" class="login__input" placeholder="Username"/>
        </div>
        <div class="login__row">
          <svg class="login__icon pass svg-icon" viewBox="0 0 20 20">
            <path d="M0,20 20,20 20,8 0,8z M10,13 10,16z M4,8 a6,8 0 0,1 12,0" />
          </svg>
          <input type="password" ng-model="user.password" class="login__input" placeholder="Password"/>
        </div>
        <div class="login__row system_code">
          <i class="fa fa-diamond"> </i>
          <input type="text" ng-model="user.system_code" class="login__input" placeholder="System Code"/>
        </div>
        <div class="error-message" ng-if="message">
            {literal}{{ message }}{/literal}
        </div>
        <button type="submit" class="login__submit" ng-disabled="disabled()">{$app->lang('common-btn-login')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
        <p class="login__signup"><a href="/{$app->lang('login-url-forgot_password')}">{$app->lang('login-menu-forgot_password')}</a></p>
      </div>
    </div>
    </form>
    <div class="login" ng-show="show_form_code">
      <div class="login__form_input_code">
        <span class="form-label">Bạn vui lòng nhập mã</span><br/>
        <input type="text" ng-model="user.input_code" class="form-control" ng-enter="continue()" /><br/>
        <div class="error-message" ng-if="message_code">
            {literal}{{ message_code }}{/literal}
        </div>
        <input type="button" class="btn btn-sm btn-primary" value="Tiếp tục" ng-click="continue()" />
      </div>
    </div>
  </div>
</div>