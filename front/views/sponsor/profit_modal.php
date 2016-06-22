<div ng-controller="ProfitModalCtrl">
{literal}
<div class="modal-header">
  <h3 class="modal-title">Báo cáo lợi nhuận cho nhánh: {{sponsor.item.username}}</h3>
</div>
<div class="modal-body dashboard-main test153">
  <p class="loading" ng-show="loading"><i class="fa fa-spinner fa-spin"></i></p>
  <div ng-show="!loading">
  <div class="form-group">
    <div class="bold"></div>
    <div id="result_f1">
        
    </div>
    <p>Dang cap nhat!</p>
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