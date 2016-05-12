<div class="modal-header">
  <h3 class="modal-title">Phân quyền nhận tin</h3>
</div> 
<div class="modal-body dashboard-main">
  <div>Danh sách thiết bị nhận tin</div>
  <div class="table-responsive">
   <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin" ></i></p>
   <table class="table table-bordered table-striped" ng-hide="loading">
    <thead>
      <tr>
        <th class="th-ord">#</th>
        <th class="th-name">Hardware Id</th>
        <th class="th-name">Hardware Info</th>
      </tr>
    </thead>
    <tbody>
      {literal}
      <tr ng-repeat="gcm in gcms">
        <td> {{ $index + 1 }} </td>
        <td> {{ gcm.hardware_id }} </td>
        <td> {{ gcm.hardware_info }} </td>
      </tr>
      <tr ng-if="users.length == 0">
        <td colspan="7">Chưa có thiết bị nào!</td>
      </tr>
      {/literal}
    </tbody>
  </table>
  </div> 
</div>
<div class="modal-footer">
  <!--button class="btn btn-sm btn-primary" ng-click="ok()" ng-disabled="disabled()">{$app->lang('common-btn-save')} <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></button-->
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>