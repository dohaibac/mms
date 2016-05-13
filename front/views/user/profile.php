<div class="dashboard-main">
<form class="form-signin" role="form"  ng-submit="submit()">
<div class="panel panel-info">
<div class="panel-heading">
  <h3 class="panel-title" ng-init="user.email = '{{$user->email}}'">{literal}{{ user.email }}{/literal}</h3>
</div>
<div class="panel-body">
  <div class="row">
    <div align="center" class="col-md-3 col-lg-3 "> 
     <a class="avatar"><i class="fa fa-user"></i></a>
    </div>
    <div class=" col-md-9 col-lg-9 "> 
      <table class="table table-user-information">
        <tbody>
          <tr ng-init="user.display_name = '{{$user->display_name}}'">
            <td>{$app->lang('profile-label-display_name')}:</td>
            <td>
              <span ng-hide="editing">
              {literal}{{ user.display_name }}{/literal}
              </span>
              <span ng-show="editing">
                <input class="form-control" ng-model="user.display_name" ng-maxlength="255"/>
              </span>
            </td>
          </tr>
          <tr ng-init="user.mobile = '{{$user->mobile}}'">
            <td>{$app->lang('profile-label-mobile')}:</td>
            <td>
              <span ng-hide="editing">
              {literal}{{ user.mobile }}{/literal}
              </span>
              <span ng-show="editing">
              <input class="form-control" ng-model="user.mobile"  ng-maxlength="20"/>
              </span>
             </td>
          </tr>
          <tr ng-init="user.phone = '{{$user->phone}}'">
            <td>{$app->lang('profile-label-phone')}:</td>
            <td>
              <span ng-hide="editing">
                {literal}{{ user.phone }}{/literal}
              </span>
              <span ng-show="editing">
              <input class="form-control" ng-model="user.phone" ng-maxlength="20"/>
              </span>
             </td>
          </tr>
          <tr ng-init="user.addr = '{{$user->addr}}'">
            <td>{$app->lang('profile-label-addr')}:</td>
            <td>
              <span ng-hide="editing">
                {literal}{{ user.addr }}{/literal}
              </span>
              <span ng-show="editing">
              <input class="form-control" ng-model="user.addr" ng-maxlength="255"/>
              </span>
             </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <div ng-class="message_type == 1 ? 'error-message' : 'success'" ng-if="message">
                 {literal}{{ message }}{/literal}
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
<div class="panel-footer">
  {if $app->user->data()->email_confirmed == 1}
    <span>{$app->lang('profile-label-email_confirming')}</span>
      <a class="btn btn-sm btn-primary" type="button" data-toggle="tooltip"><i class="glyphicon glyphicon-envelope"></i></a>
  {else}
  <span>{$app->lang('profile-label-email_confirmed')}</span> 
  <a class="btn confirmed"><i class="fa fa-check"></i></a>
  {/if}
  <span class="pull-right">
    <span ng-hide="editing">
      <a ng-click="editing = true" class="btn btn-sm btn-warning" type="button"><i class="glyphicon glyphicon-edit"></i> {$app->lang('common-btn-edit_info')}</a>
    </span>
    <span ng-show="editing">
      <a ng-disabled="disabled()" ng-click="submit()" 
        class="btn btn-sm btn-primary" type="button"><i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></a>
      <a ng-disabled="processing" ng-click="editing = false" class="btn btn-sm btn-default" type="button"><i class="fa fa-times"></i> {$app->lang('common-btn-cancel')}</a>
    </span>
  </span>
</div>
</div>
</form>
</div>