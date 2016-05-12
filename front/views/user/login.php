<div class="row">
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
{if !$is_guest}
<div class="readonly-email">
  {if $user->display_name != ''}
<span><b>{{$user->display_name}}</b></span>
{/if}
</div>
<div class="readonly-email">
<span ng-model="user.email" 
    ng-init="user.email='{{$user->email}}'" value="{{$user->email}}"
     placeholder="Email address" required autofocus accesskey="e" disabled="disabled">{{$user->email}}</span>
</div>
{else}
<label for="email">Email / User name</label>
<input ng-model="user.email" type="text" id="email" name="email" class="form-control" 
      required autofocus accesskey="e" >
{/if}
<label for="password">Password</label>
<input ng-model="user.password"  type="password" id="password" name="password" 
  class="form-control">
<label for="system_code">System Code</label>
<input ng-model="user.system_code"  type="text" id="system_code" name="system_code" class="form-control" >

<input type="hidden" value="{{$from}}" ng-init="user.from='{{$from}}'" />

<div class="error-message" ng-if="message">
    {literal}{{ message }}{/literal}
</div>
<div class="login-btn">
<button class="btn btn-sm btn-primary" 
  type="submit" ng-disabled="disabled()">{$app->lang('common-btn-login')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
</div>
<div class="login-link">
  <ul>
    {if !$is_guest}
    <li><i class="fa fa-user"></i><a href="/{$app->lang('common-url-logout')}"> {$app->lang('login-menu-try_a_dif_account')}</a></li>
    {/if}
    <li><i class="fa fa-minus-square"></i><a href="/{$app->lang('login-url-forgot_password')}"> {$app->lang('login-menu-forgot_password')}</a></li>
  </ul>
</div>
</form>
</div>
</div>
<div class="col-md-4"></div>
</div>