<div class="dashboard-main">
<script type="text/javascript" src="{$app->appConf->theme_default}/js/controllers/user/change_password.js"></script>
<form class="form-changepassword" role="form" 
  ng-controller="ChangepasswordController" ng-submit="submit()" autocomplete="off">
<div class="panel panel-info">
<div class="panel-heading">
  <h3 class="panel-title">{$app->lang('change_password-label-title')}</h3>
</div>
<div class="panel-body">
  <div class="row">
    <div class=" col-md-12 col-lg-12 "> 
      <table class="table table-user-information">
        <tbody>
          <tr>
            <td>{$app->lang('change_password-label-password_old')}:</td>
            <td>
                <input class="form-control" type="password" required ng-minlength="6" ng-model="user.password_old" ng-maxlength="255"/>
            </td>
          </tr>
          <tr>
            <td>{$app->lang('change_password-label-password_new')}:</td>
            <td>
              <input class="form-control" type="password" required ng-minlength="6" ng-model="user.password_new"  ng-maxlength="255"/>
             </td>
          </tr>
          <tr>
            <td>{$app->lang('change_password-label-password_renew')}:</td>
            <td>
              <input class="form-control"type="password" required ng-minlength="6" ng-model="user.password_renew" ng-maxlength="255"/>
             </td>
          </tr>
          <tr>
            <td></td>
            <td>
              <div>
                <span class="note">{$app->lang('common-label-password_guide_input')}</span>
              </div>
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
  <div class="row">
  <div class="col-md-5 col-lg-5"></div>
  <div class="col-md-7 col-lg-7">
  <button ng-disabled="disabled()" ng-click="submit()" 
    class="btn btn-sm btn-primary" type="submit">
    <i class="glyphicon glyphicon-save"></i> {$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button>
  </div>
  </div>
</div>
</div>
</form>
</div>