<div ng-controller="GdexApproveEditCtrl">
{literal}
<div class="modal-header">
  <h3 class="modal-title">Xác nhận GD đã hoàn thành</h3>
</div>
<div class="modal-body dashboard-main"> 
   <div class="table-responsive">
     <div class="form-group">
      <div class="col-md-2 align-right">
        <label class="control-label">Mã</label>
      </div>
      <div class="col-md-10">
        <input ng-model="gd.sponsor" readonly="readonly" type="input" name="sponsor" class="form-control" 
          required ng-maxlength="255">
      </div>
      <div class="clearfix"></div>
    </div>
    <div class="form-group">
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
  <a ng-disabled="disabled()" ng-click="submit()" 
    class="btn btn-sm btn-primary" type="button"><i class="glyphicon glyphicon-save"></i> Xác nhận <i class="fa fa-spinner fa-spin" ng-show="processing" ></i></a>
  <button class="btn btn-sm btn-upgrade" ng-click="cancel()">Thoát</button>
</div>
{/literal}
</div>