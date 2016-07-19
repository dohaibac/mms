<div ng-controller="SponsorTest153ModalCtrl">
{literal}
<div class="modal-header">
  <h3 class="modal-title">Kiểm tra sơ đồ 1/5/3</h3>
</div>
<div class="modal-body dashboard-main test153">
  <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin"></i></p>
  <div ng-show="!loading">
  <div class="form-group">
    <div class="bold">Danh sách các mã chưa đủ 5 F1</div>
    {literal}
    <table style="width:100%">
      <tr><td>Mã</td><td>Number of F1</td></tr>
      <tr ng-repeat="f1 in less_than_5_f1_list">
        <td><a href="javascript:void(0)" ng-click="find(f1)">{{ f1.username }}</a></td>
        <td>{{ f1.n_f1 }}</td>
      </tr>
      <tr ng-if="less_than_5_f1_list.length == 0">
        <td colspan="2">
          Không có mã nào!
        </td>
      </tr>
    </table>
    {/literal}
  </div>
  <div class="form-group">
    <div class="bold">Danh sách các mã chưa phát triển đủ 3 nhánh</div>
    {literal}
    <table style="width:100%">
      <tr><td>Mã</td><td>Number of Fork</td></tr>
      <tr ng-repeat="fork in less_than_3_fork_list">
        <td><a href="javascript:void(0)" ng-click="find(fork)">{{ fork.username }}</a></td>
        <td>{{ fork.n_fork }}</td>
      </tr>
      <tr ng-if="less_than_3_fork_list.length == 0">
        <td colspan="2">
          Không có mã nào!
        </td>
      </tr>
    </table>
    {/literal}
  </div>
  <div class="form-group" ng-if="message">
    <div class="col-md-2 align-right">
    <label class="control-label"></label>
    </div>
    <div class="col-md-10">
    <div class="alert alert-warning" ng-if="message">
    <div ng-class="message_type == 1 ? 'error-message' : 'success'">
      {literal}{{ message }}{/literal}
    </div>
    </div>
    </div>
    <div class="clearfix"></div>
  </div>
  </div>
 </div>
<div class="modal-footer">
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}
</div>